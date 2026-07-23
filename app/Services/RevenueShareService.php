<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;

/**
 * Revenue Share Service
 *
 * This service is responsible for calculating the revenue share for a payment.
 *
 * @package App\Services
 */
class RevenueShareService
{
    public function __construct(private SettingsRepository $settingsRepository)
    {
    }

    public function settings(): array
    {
        return $this->settingsRepository->get('revenue.distribution', [
            'mode' => 'percentage',
            'value' => 0,
        ]);
    }

    public function calculate(float $amount): array
    {
        $settings = $this->settings();
        $mode = $settings['mode'] ?? 'percentage';
        $value = (float) ($settings['value'] ?? 0);

        $commission = 0.0;

        if ($amount <= 0) {
            return [
                'platform_commission' => 0.0,
                'instructor_earning' => 0.0,
            ];
        }

        if ($mode === 'fixed') {
            $commission = min($value, $amount);
        } else {
            if ($value < 0) {
                $value = 0;
            }
            if ($value > 100) {
                $value = 100;
            }
            $commission = round($amount * ($value / 100), 2);
        }

        $commission = round($commission, 2);
        $instructor = round($amount - $commission, 2);

        if ($instructor < 0) {
            $instructor = 0.0;
        }

        return [
            'platform_commission' => $commission,
            'instructor_earning' => $instructor,
        ];
    }

    public function process(Payment $payment, bool $force = false): Payment
    {
        if (!$force && $payment->commission_processed) {
            return $payment;
        }

        $amount = (float) $payment->amount;
        $distribution = $this->calculate($amount);
        $platformCommission = $distribution['platform_commission'];
        $instructorEarning = $distribution['instructor_earning'];

        return DB::transaction(function () use ($payment, $platformCommission, $instructorEarning) {
            $payment->platform_commission = $platformCommission;
            $payment->commission_processed = true;

            // Handle Bundle Revenue Share
            if ($payment->bundle_id) {
                // Eager load bundle and its courses
                $payment->loadMissing('bundle.courses');
                $bundle = $payment->bundle;
                
                if ($bundle) {
                    $vendor = $bundle->vendor;
                    
                    if ($vendor && $vendor->hasRole('admin')) {
                        // Multi-instructor bundle (Admin created)
                        // Split revenue among instructors based on the number of courses they have in the bundle
                        $totalCourses = $bundle->courses->count();
                        if ($totalCourses > 0) {
                            $instructorCounts = [];
                            foreach ($bundle->courses as $c) {
                                if (!isset($instructorCounts[$c->instructor_id])) {
                                    $instructorCounts[$c->instructor_id] = 0;
                                }
                                $instructorCounts[$c->instructor_id]++;
                            }
                            
                            foreach ($instructorCounts as $instructorId => $count) {
                                $share = round(($count / $totalCourses) * $instructorEarning, 2);
                                if ($share > 0) {
                                    \App\Models\User::where('id', $instructorId)->increment('balance', $share);
                                }
                            }
                        }
                    } else if ($vendor && $vendor->hasRole('instructor')) {
                        // All earnings go to the bundle vendor
                        $vendor->increment('balance', $instructorEarning);
                    }
                    
                    $payment->instructor_earning = $instructorEarning; // Record total distributed instructor earning
                }
            } else {
                // Standard Single Course Revenue Share
                $payment->loadMissing('enrollment.course.instructor');
                $instructor = optional($payment->enrollment)->course?->instructor;
                $payment->instructor_earning = $instructorEarning;

                if ($instructor && $instructorEarning > 0) {
                    $instructor->increment('balance', $instructorEarning);
                }
            }

            $payment->save();
            return $payment->fresh();
        });
    }
}

