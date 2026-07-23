<?php

namespace App\Http\Controllers\Api\Instructor;

use App\Http\Controllers\Controller;
use App\Models\InstructorWithdrawal;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EarningsController extends Controller
{
    /**
     * GET /api/instructor/earnings
     * Returns stats, monthly chart data, and paginated transactions.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user->is_approved) {
            return response()->json(['success' => false, 'message' => 'Your account is pending approval.'], 403);
        }

        $instructorId = $user->id;
        $currency = strtoupper(settings('general.currency_code', 'USD'));
        $minimumWithdrawal = (float) settings('withdrawals.settings.minimum_amount', 10);

        $basePaymentQuery = Payment::query()
            ->whereHas('enrollment.course', fn($q) => $q->where('instructor_id', $instructorId));

        $completedQ = (clone $basePaymentQuery)->where('status', Payment::STATUS_COMPLETED);

        $totalEarnings    = (clone $completedQ)->sum('instructor_earning');
        $pendingBalance   = (clone $basePaymentQuery)->where('status', Payment::STATUS_PENDING)->sum('instructor_earning')
                         + (clone $completedQ)->where('commission_processed', false)->sum('instructor_earning');
        $withdrawnTotal   = InstructorWithdrawal::where('instructor_id', $instructorId)
                                ->where('status', InstructorWithdrawal::STATUS_COMPLETED)->sum('amount');
        $thisMonth        = (clone $completedQ)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->sum('instructor_earning');
        $lastMonth        = (clone $completedQ)->whereBetween('created_at', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()])->sum('instructor_earning');
        $thisYear         = (clone $completedQ)->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->sum('instructor_earning');

        $stats = [
            'currency'            => $currency,
            'available_balance'   => (float) $user->balance,
            'pending_balance'     => (float) $pendingBalance,
            'total_earnings'      => (float) $totalEarnings,
            'withdrawn_total'     => (float) $withdrawnTotal,
            'this_month'          => (float) $thisMonth,
            'last_month'          => (float) $lastMonth,
            'this_year'           => (float) $thisYear,
            'minimum_withdrawal'  => $minimumWithdrawal,
        ];

        // Monthly chart data (last 12 months)
        $monthlyStart = Carbon::now()->startOfMonth()->subMonths(11);
        $monthlyRaw = (clone $completedQ)
            ->where('created_at', '>=', $monthlyStart)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as ym, SUM(instructor_earning) as earnings')
            ->groupBy('ym')
            ->orderBy('ym')
            ->pluck('earnings', 'ym');

        $monthlyData = [];
        for ($i = 0; $i < 12; $i++) {
            $m = $monthlyStart->copy()->addMonths($i);
            $key = $m->format('Y-m');
            $monthlyData[] = [
                'month'    => $m->format('M'),
                'label'    => $m->format('M Y'),
                'earnings' => (float) ($monthlyRaw[$key] ?? 0),
            ];
        }

        // Paginated transactions (sales + withdrawals merged)
        $perPage = (int) $request->get('per_page', 15);
        $page    = (int) $request->get('page', 1);

        $sales = (clone $basePaymentQuery)
            ->with(['enrollment.course:id,title', 'enrollment.user:id,name'])
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($p) => [
                'id'          => 'sale-' . $p->id,
                'type'        => 'sale',
                'description' => optional($p->enrollment?->course)->title ?? 'Course Sale',
                'student'     => optional($p->enrollment?->user)->name,
                'amount'      => (float) $p->instructor_earning,
                'currency'    => $currency,
                'date'        => $p->created_at?->toIso8601String(),
                'status'      => $p->status,
            ]);

        $withdrawals = InstructorWithdrawal::where('instructor_id', $instructorId)
            ->orderByDesc('requested_at')
            ->get()
            ->map(fn($w) => [
                'id'          => 'withdrawal-' . $w->id,
                'type'        => 'withdrawal',
                'description' => 'Withdrawal via ' . ucfirst(str_replace('_', ' ', $w->method)),
                'student'     => null,
                'amount'      => -1 * (float) $w->amount,
                'currency'    => $currency,
                'date'        => ($w->requested_at ?? $w->created_at)?->toIso8601String(),
                'status'      => $w->status,
                'reference'   => $w->reference,
            ]);

        $all      = $sales->merge($withdrawals)->sortByDesc('date')->values();
        $total    = $all->count();
        $items    = $all->forPage($page, $perPage)->values();

        return response()->json([
            'success' => true,
            'data'    => [
                'stats'         => $stats,
                'monthly_chart' => $monthlyData,
                'transactions'  => [
                    'data'          => $items,
                    'current_page'  => $page,
                    'last_page'     => (int) ceil($total / $perPage),
                    'total'         => $total,
                    'per_page'      => $perPage,
                ],
            ],
        ]);
    }

    /**
     * GET /api/instructor/withdrawals
     * Returns withdrawal list with balance summary.
     */
    public function withdrawals(Request $request)
    {
        $user = $request->user();

        if (!$user->is_approved) {
            return response()->json(['success' => false, 'message' => 'Your account is pending approval.'], 403);
        }

        $currency            = strtoupper(settings('general.currency_code', 'USD'));
        $minimumWithdrawal   = (float) settings('withdrawals.settings.minimum_amount', 10);
        $availableBalance    = (float) $user->balance;

        $pendingBalance = InstructorWithdrawal::where('instructor_id', $user->id)
            ->whereIn('status', [InstructorWithdrawal::STATUS_PENDING, InstructorWithdrawal::STATUS_PROCESSING])
            ->sum('amount');

        $query = InstructorWithdrawal::where('instructor_id', $user->id)->orderByDesc('requested_at');

        $completedCount = (clone $query)->where('status', InstructorWithdrawal::STATUS_COMPLETED)->count();
        $pendingCount   = (clone $query)->whereIn('status', [InstructorWithdrawal::STATUS_PENDING, InstructorWithdrawal::STATUS_PROCESSING])->count();

        $perPage  = (int) $request->get('per_page', 15);
        $paginated = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => [
                'available_balance'  => $availableBalance,
                'pending_balance'    => (float) $pendingBalance,
                'minimum_withdrawal' => $minimumWithdrawal,
                'currency'           => $currency,
                'completed_count'    => $completedCount,
                'pending_count'      => $pendingCount,
                'withdrawals'        => $paginated,
            ],
        ]);
    }

    /**
     * POST /api/instructor/withdrawals
     * Submit a new withdrawal request.
     */
    public function storeWithdrawal(Request $request)
    {
        $user = $request->user();

        if (!$user->is_approved) {
            return response()->json(['success' => false, 'message' => 'Your account is pending approval.'], 403);
        }

        $minimumWithdrawal = (float) settings('withdrawals.settings.minimum_amount', 10);
        $currency          = strtoupper(settings('general.currency_code', 'USD'));

        $validated = $request->validate([
            'method'         => 'required|in:bank_transfer,paypal,stripe',
            'amount'         => ['required', 'numeric', 'min:' . $minimumWithdrawal],
            'method_details' => 'nullable|string|max:500',
            'notes'          => 'nullable|string|max:1000',
        ]);

        $amount = (float) $validated['amount'];

        if ($amount > $user->balance) {
            return response()->json(['success' => false, 'message' => 'Withdrawal amount cannot exceed available balance.'], 422);
        }

        DB::transaction(function () use ($user, $amount, $validated, $currency) {
            $reference = 'WD-' . now()->format('Ymd') . '-' . strtoupper(str()->random(5));
            InstructorWithdrawal::create([
                'instructor_id'  => $user->id,
                'amount'         => $amount,
                'currency'       => $currency,
                'method'         => $validated['method'],
                'method_details' => $validated['method_details'] ?? null,
                'status'         => InstructorWithdrawal::STATUS_PENDING,
                'reference'      => $reference,
                'notes'          => $validated['notes'] ?? null,
                'requested_at'   => now(),
            ]);
            $user->decrement('balance', $amount);
        });

        return response()->json([
            'success' => true,
            'message' => 'Withdrawal request submitted successfully.',
        ]);
    }
}
