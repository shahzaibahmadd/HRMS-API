<?php

use App\Http\Controllers\{Announcement\AnnouncementController,
    Attendance\AttendanceController,
    Auth\AuthController,
    LeaveRequests\LeaveRequestController,
    Payroll\PayrollController,
    Payslip\PayslipController,
    PerformanceReview\PerformanceReviewController,
    Task\TaskController,
    User\UserController};
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:api'])->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);


    Route::middleware('role')->group(function () {

        // User Management
        Route::apiResource('/users', UserController::class)->except(['show']);
        Route::get('/list-users', [UserController::class, 'index']);

        // Attendance
        Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn']);
        Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut']);
        Route::get('/attendances', [AttendanceController::class, 'index']);

        // Leave Requests
        Route::post('/leave/request', [LeaveRequestController::class, 'store']);
        Route::get('/leave/my', [LeaveRequestController::class, 'myLeaves']);
        Route::get('/leave/pending', [LeaveRequestController::class, 'pendingLeaves']);
        Route::get('/list-leaves', [LeaveRequestController::class, 'index']);
        Route::put('/leave/status/{id}', [LeaveRequestController::class, 'updateStatus']);
        Route::post('/delete-leave-request/{leaveRequest}', [LeaveRequestController::class, 'destroy']);

        // Payroll
        Route::prefix('payroll')->group(function () {
            Route::get('/list', [PayrollController::class, 'index']);
            Route::post('/', [PayrollController::class, 'store']);
            Route::get('/{userId}', [PayrollController::class, 'show']);
        });

        // Payslips
        Route::prefix('payslips')->group(function () {
            Route::post('/generate/{payroll}', [PayslipController::class, 'generate']);
            Route::get('/download/{payslip}', [PayslipController::class, 'download']);
        });

        // Tasks
        Route::post('/create-task', [TaskController::class, 'store']);
        Route::get('/list-task', [TaskController::class, 'index']);

        // Performance Review
        Route::post('/create-performance-review', [PerformanceReviewController::class, 'store']);
        Route::post('/delete-performance-review/{performanceReview}', [PerformanceReviewController::class, 'destroy']);
        Route::put('/update-performance-review/{performanceReview}', [PerformanceReviewController::class, 'update']);
        Route::get('/show-performance-review/{performanceReview}', [PerformanceReviewController::class, 'show']);
        Route::get('/list-performance-review', [PerformanceReviewController::class, 'index']);

    });

    Route::get('announcements', [AnnouncementController::class, 'index']);
    Route::post('announcements', [AnnouncementController::class, 'store']);

});
