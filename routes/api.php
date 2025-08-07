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

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {

    Route::get('/me', [AuthController::class, 'me'])->name('me');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::middleware('role')->group(function () {

        // User Management

        Route::get('/list-users', [UserController::class, 'index'])->name('users.list');
        Route::post('/update-user/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('/delete-user/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/restore-user/{user}', [UserController::class, 'restore'])->name('users.restore');

        // Attendance
        Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
        Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
        Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances');

        // Leave Requests
        Route::post('/leave/request', [LeaveRequestController::class, 'store'])->name('leave.request');
        Route::get('/leave/my', [LeaveRequestController::class, 'myLeaves'])->name('leave.my');
        Route::get('/leave/pending', [LeaveRequestController::class, 'pendingLeaves'])->name('leave.pending');
        Route::get('/list-leaves', [LeaveRequestController::class, 'index'])->name('leaves.list');
        Route::put('/leave/status/{id}', [LeaveRequestController::class, 'updateStatus'])->name('leave.status');
        Route::post('/delete-leave-request/{leaveRequest}', [LeaveRequestController::class, 'destroy'])->name('leave.destroy');

        // Payroll
        Route::prefix('payroll')->group(function () {
            Route::get('/list', [PayrollController::class, 'index'])->name('payroll.list');
            Route::post('/', [PayrollController::class, 'store'])->name('payroll.store');
            Route::get('/{userId}', [PayrollController::class, 'show'])->name('payroll.show');
            Route::post('/delete/{payrollId}', [PayrollController::class, 'destroy'])->name('payroll.destroy');
            Route::put('/update/{payrollId}', [PayrollController::class, 'update'])->name('payroll.update');
        });


            Route::prefix('payslips')->group(function () {
            Route::post('/generate/{payroll}', [PayslipController::class, 'generate'])->name('payslips.generate');
            Route::get('/download/{payslip}', [PayslipController::class, 'download'])->name('payslips.download');
        });


        Route::post('/create-task', [TaskController::class, 'store'])->name('task.store');
        Route::get('/list-task', [TaskController::class, 'index'])->name('task.list');
        Route::put('/update-task/{task}', [TaskController::class, 'update'])->name('task.update');



        Route::post('/create-performance-review', [PerformanceReviewController::class, 'store'])->name('performanceReview.store');
        Route::post('/delete-performance-review/{performanceReview}', [PerformanceReviewController::class, 'destroy'])->name('performanceReview.destroy');
        Route::put('/update-performance-review/{performanceReview}', [PerformanceReviewController::class, 'update'])->name('performanceReview.update');
        Route::get('/show-performance-review/{performanceReview}', [PerformanceReviewController::class, 'show'])->name('performanceReview.show');
        Route::get('/list-performance-review', [PerformanceReviewController::class, 'index'])->name('performanceReview.list');

    });

    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');

});
