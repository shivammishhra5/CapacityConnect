<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\InstructorController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\CourseEnrollmentController;
use App\Http\Controllers\Api\BundleController;
use App\Http\Controllers\Api\StudentCourseController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\CustomPageController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Student\AiChatController;

Route::get('/settings', [SettingController::class, 'index']);
Route::get('/settings/pages', [CustomPageController::class, 'index']);
Route::get('/settings/pages/{slug}', [CustomPageController::class, 'show']);

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login/otp/verify', [AuthController::class, 'verifyOtp']);
    Route::post('/login/otp/resend', [AuthController::class, 'resendOtp']);
});

Route::get('/home', [HomeController::class, 'index']);
Route::get('/courses/recent', [HomeController::class, 'recentCourses']);
Route::get('/courses', [CourseController::class, 'index']);
// Categories
Route::get('/categories', [CourseController::class, 'categories']);
Route::get('/courses/{id}', [CourseController::class, 'show']);
Route::get('/bundles', [BundleController::class, 'index']);
Route::get('/bundles/{id}', [BundleController::class, 'show']);
Route::get('/video/stream', [FileController::class, 'stream']);
Route::get('/instructors', [InstructorController::class, 'index']);
Route::get('/instructors/{id}', [InstructorController::class, 'show']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/certificates/download/signed/{id}', [CertificateController::class, 'downloadSigned'])->name('api.certificates.download.signed')->middleware('signed');

// Community Q&A (Public)
Route::get('/community/questions', [CommunityController::class, 'index']);
Route::get('/community/questions/{id}', [CommunityController::class, 'show']);

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Profile & Settings
    Route::post('/user/profile', [ProfileController::class, 'updateProfile']);
    Route::post('/user/profile-photo', [ProfileController::class, 'updateProfilePhoto']);
    Route::post('/user/password', [ProfileController::class, 'updatePassword']);
    Route::post('/user/delete-request', [ProfileController::class, 'requestDeleteAccount']);
    // ...
    Route::get('/user/delete-request', [ProfileController::class, 'getDeleteRequestStatus']);
    Route::get('/user/settings/notifications', [ProfileController::class, 'getNotificationSettings']);
    Route::put('/user/settings/notifications', [ProfileController::class, 'updateNotificationSettings']);

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy']);

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Enrollment
    Route::post('/courses/{id}/enroll', [CourseEnrollmentController::class, 'enroll']);
    Route::post('/bundles/{id}/checkout', [CourseEnrollmentController::class, 'enrollBundle']);
    Route::post('/events/{id}/book', [EventController::class, 'book']);
    Route::get('/user/bookings', [EventController::class, 'myBookings']);
    Route::get('/user/bookings/{id}', [EventController::class, 'showBooking']);
    Route::post('/payments/razorpay/verify', [CourseEnrollmentController::class, 'razorpayVerify']);
    Route::post('/payments/sslcommerz/verify', [CourseEnrollmentController::class, 'sslcommerzVerify']);
    Route::post('/payments/stripe/verify', [CourseEnrollmentController::class, 'stripeVerify']);
    Route::post('/payments/paystack/verify', [CourseEnrollmentController::class, 'paystackVerify']);
    Route::post('/payments/mollie/verify', [CourseEnrollmentController::class, 'mollieVerify']);
    Route::post('/payments/bkash/verify', [CourseEnrollmentController::class, 'bkashVerify']);
    Route::get('/user/courses', [CourseController::class, 'myCourses']);
    Route::get('/user/certificates', [CertificateController::class, 'index']);
    Route::get('/user/certificates/{id}', [CertificateController::class, 'show']);
    Route::get('/user/certificates/{id}/download', [CertificateController::class, 'download']);

    // Payment History
    Route::get('/user/payments', [App\Http\Controllers\Api\PaymentController::class, 'index']);
    Route::get('/user/payments/{id}/receipt', [App\Http\Controllers\Api\PaymentController::class, 'downloadReceipt']);

    // Course Learning & Progress
    Route::get('/user/courses/{course}/learn', [StudentCourseController::class, 'show']);
    // ...
    Route::get('/user/courses/{course}/lessons/{lesson}', [StudentCourseController::class, 'loadLesson']);
    Route::post('/user/courses/{course}/lessons/{lesson}/complete', [StudentCourseController::class, 'markLessonComplete']);

    // Quiz & Assignment Routes
    Route::get('/user/assignments', [StudentCourseController::class, 'myAssignments']);
    Route::get('/user/quizzes', [StudentCourseController::class, 'myQuizzes']);
    Route::get('/user/courses/{course}/quizzes/{quiz}', [StudentCourseController::class, 'loadQuiz']);
    Route::post('/user/courses/{course}/quizzes/{quiz}/submit', [StudentCourseController::class, 'submitQuiz']);
    Route::get('/user/courses/{course}/assignments/{assignment}', [StudentCourseController::class, 'loadAssignment']);
    Route::post('/user/courses/{course}/assignments/{assignment}/submit', [StudentCourseController::class, 'submitAssignment']);
    Route::post('/payments/paypal/verify', [CourseEnrollmentController::class, 'paypalVerify']);

    // Community Q&A (Protected)
    Route::post('/community/questions', [CommunityController::class, 'store']);
    Route::post('/community/questions/{id}/answers', [CommunityController::class, 'storeAnswer']);
    Route::post('/community/answers/{id}/accept', [CommunityController::class, 'markAnswerAccepted']);
    Route::post('/community/vote/{type}/{id}', [CommunityController::class, 'vote']);

    // AI Chat
    Route::get('/ai-chat', [AiChatController::class, 'index']);
    Route::post('/ai-chat/send', [AiChatController::class, 'sendMessage']);

    // Student ↔ Instructor Chat
    Route::prefix('messages')->group(function () {
        Route::get('/', [ChatController::class, 'index']);
        Route::get('/requests', [ChatController::class, 'requests']);
        Route::get('/unread-count', [ChatController::class, 'unreadCount']);
        Route::get('/instructors/search', [ChatController::class, 'searchInstructors']);
        Route::post('/start', [ChatController::class, 'startConversation']);
        Route::get('/{id}', [ChatController::class, 'show']);
        Route::post('/{id}/send', [ChatController::class, 'sendMessage']);
        Route::get('/{id}/poll', [ChatController::class, 'poll']);
    });
});

// Instructor App Routes
Route::prefix('instructor')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [\App\Http\Controllers\Api\Instructor\AuthController::class, 'register']);
        Route::post('/login', [\App\Http\Controllers\Api\Instructor\AuthController::class, 'login']);
        Route::post('/login/otp/verify', [\App\Http\Controllers\Api\Instructor\AuthController::class, 'verifyOtp']);
        Route::post('/login/otp/resend', [\App\Http\Controllers\Api\Instructor\AuthController::class, 'resendOtp']);
        Route::post('/forgot-password', [\App\Http\Controllers\Api\Instructor\AuthController::class, 'forgotPassword']);
    });
    
    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
        Route::get('/user', [\App\Http\Controllers\Api\Instructor\AuthController::class, 'user']);
        Route::post('/logout', [\App\Http\Controllers\Api\Instructor\AuthController::class, 'logout']);
        Route::get('/dashboard', [\App\Http\Controllers\Api\Instructor\DashboardController::class, 'index']);
        Route::get('/analytics', [\App\Http\Controllers\Api\Instructor\AnalyticsController::class, 'index']);
        
        // Settings
        Route::prefix('settings')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\Instructor\SettingsController::class, 'index']);
            Route::post('/profile', [\App\Http\Controllers\Api\Instructor\SettingsController::class, 'updateProfile']);
            Route::post('/profile-photo', [\App\Http\Controllers\Api\Instructor\SettingsController::class, 'updateProfilePhoto']);
            Route::post('/password', [\App\Http\Controllers\Api\Instructor\SettingsController::class, 'updatePassword']);
            Route::post('/delete-request', [\App\Http\Controllers\Api\Instructor\SettingsController::class, 'deleteAccount']);
            Route::put('/notifications', [\App\Http\Controllers\Api\Instructor\SettingsController::class, 'updateNotifications']);
        });

        Route::get('/courses', [\App\Http\Controllers\Api\Instructor\CourseController::class, 'index']);
        Route::get('/courses/{id}', [\App\Http\Controllers\Api\Instructor\CourseController::class, 'show']);
        
        Route::get('/bundles', [\App\Http\Controllers\Api\Instructor\BundleController::class, 'index']);
        Route::get('/bundles/{id}', [\App\Http\Controllers\Api\Instructor\BundleController::class, 'show']);

        // Chat Routes
        Route::get('/chat', [\App\Http\Controllers\Api\Instructor\ChatController::class, 'index']);
        Route::get('/chat/requests', [\App\Http\Controllers\Api\Instructor\ChatController::class, 'requests']);
        Route::post('/chat/accept/{id}', [\App\Http\Controllers\Api\Instructor\ChatController::class, 'accept']);
        Route::post('/chat/decline/{id}', [\App\Http\Controllers\Api\Instructor\ChatController::class, 'decline']);
        Route::get('/chat/unread-count', [\App\Http\Controllers\Api\Instructor\ChatController::class, 'unreadCount']);
        Route::post('/chat/start', [\App\Http\Controllers\Api\Instructor\ChatController::class, 'startConversation']);
        Route::get('/chat/{id}', [\App\Http\Controllers\Api\Instructor\ChatController::class, 'show']);
        Route::post('/chat/{id}/send', [\App\Http\Controllers\Api\Instructor\ChatController::class, 'sendMessage']);
        Route::get('/chat/{id}/poll', [\App\Http\Controllers\Api\Instructor\ChatController::class, 'poll']);

        // Assignment Routes
        Route::get('/assignments', [\App\Http\Controllers\Api\Instructor\AssignmentController::class, 'index']);
        Route::get('/assignments/{id}', [\App\Http\Controllers\Api\Instructor\AssignmentController::class, 'show']);
        Route::get('/assignments/submissions/{id}', [\App\Http\Controllers\Api\Instructor\AssignmentController::class, 'showSubmission']);
        Route::put('/assignments/submissions/{id}', [\App\Http\Controllers\Api\Instructor\AssignmentController::class, 'updateSubmission']);

        // Quiz Attempt Routes
        Route::get('/quizzes', [\App\Http\Controllers\Api\Instructor\QuizAttemptController::class, 'index']);
        Route::get('/quizzes/{id}', [\App\Http\Controllers\Api\Instructor\QuizAttemptController::class, 'show']);

        // Events
        Route::get('/events', [App\Http\Controllers\Api\Instructor\EventController::class, 'index']);
        Route::get('/events/{id}', [App\Http\Controllers\Api\Instructor\EventController::class, 'show']);
        Route::post('/events/bookings/{id}/status', [App\Http\Controllers\Api\Instructor\EventController::class, 'updateBookingStatus']);
        Route::post('/events/{id}/email', [App\Http\Controllers\Api\Instructor\EventController::class, 'sendEmail']);
        Route::get('/events/{id}/export', [App\Http\Controllers\Api\Instructor\EventController::class, 'export']);
        Route::post('/events/verify', [App\Http\Controllers\Api\Instructor\EventController::class, 'verifyTicket']);

        // Students
        Route::get('/students', [\App\Http\Controllers\Api\Instructor\StudentsController::class, 'index']);
        Route::get('/students/{id}', [\App\Http\Controllers\Api\Instructor\StudentsController::class, 'show']);

        // Reviews
        Route::get('/reviews', [\App\Http\Controllers\Api\Instructor\ReviewController::class, 'index']);
        Route::post('/reviews/{id}/reply', [\App\Http\Controllers\Api\Instructor\ReviewController::class, 'reply']);
        Route::put('/reviews/{id}/reply/{replyId}', [\App\Http\Controllers\Api\Instructor\ReviewController::class, 'updateReply']);
        Route::delete('/reviews/{id}/reply/{replyId}', [\App\Http\Controllers\Api\Instructor\ReviewController::class, 'deleteReply']);

        // Earnings & Withdrawals
        Route::get('/earnings', [\App\Http\Controllers\Api\Instructor\EarningsController::class, 'index']);
        Route::get('/withdrawals', [\App\Http\Controllers\Api\Instructor\EarningsController::class, 'withdrawals']);
        Route::post('/withdrawals', [\App\Http\Controllers\Api\Instructor\EarningsController::class, 'storeWithdrawal']);

    });
});
