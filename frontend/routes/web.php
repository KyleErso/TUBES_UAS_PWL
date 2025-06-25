<?php

// frontend/routes/web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommitteeController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MemberController;

// =================== GUEST & AUTH ===================
Route::get('/', [HomeController::class, 'index']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =================== EVENT (UMUM) ===================
Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::get('/{id}', [EventController::class, 'show'])->name('events.show');
});

// =================== ADMIN ===================
Route::prefix('dashboard')->group(function () {
    Route::get('/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');

});

// Admin Staff Routes (Grouped)
Route::prefix('admin/staff')->group(function () {
    Route::post('/', [DashboardController::class, 'addStaff'])->name('admin.staff.add');
    Route::get('/', [DashboardController::class, 'allStaff'])->name('admin.staff.all');
    Route::get('/{id}/edit', [DashboardController::class, 'editStaff'])->name('admin.staff.edit');
    Route::put('/{id}', [DashboardController::class, 'updateStaff'])->name('admin.staff.update');
    Route::delete('/{id}', [DashboardController::class, 'deleteStaff'])->name('admin.staff.delete');
});

// =================== PANITIA ===================
Route::prefix('committee')->group(function () {
    // Dashboard overview
    Route::get('/dashboard', [CommitteeController::class, 'committee'])
        ->name('committee.dashboard');

    // List all & show create form
    Route::get('/event', [CommitteeController::class, 'indexEvent'])
        ->name('committee.event.index');

    // Store new event
    Route::post('/event', [CommitteeController::class, 'storeEvent'])
        ->name('committee.event.store');

    // Delete an event
    Route::delete('/event/{id}', [CommitteeController::class, 'deleteEvent'])
        ->name('committee.event.delete');
    
    Route::post('/event/certificate', [CommitteeController::class, 'uploadCertificate'])->name('committee.event.uploadCertificate');
    Route::post('/event/scan', [CommitteeController::class, 'scanAttendance'])->name('committee.event.scanAttendance');
   
Route::get('/committee/event/scan', function() {
    return view('committee.dashboard.scan');
})->name('committee.event.scan');
});

// Deactivate an event
Route::patch('/event/{id}/deactivate', [CommitteeController::class, 'deactivateEvent'])
    ->name('committee.event.deactivate');

// =================== MEMBER ===================
Route::post('/member/register/{eventId}', [EventController::class, 'registerEvent'])->name('member.register');
Route::get('/member', [MemberController::class, 'index'])->name('member.dashboard');
Route::post('/member/upload-bukti/{id}', [MemberController::class, 'uploadBukti'])->name('member.uploadBukti');


// =================== FINANCE ===================
Route::get('/finance', [FinanceController::class, 'dashboard'])->name('finance.dashboard');
Route::put('/dashboard/finance/payment-status', [FinanceController::class, 'updatePaymentStatus'])->name('finance.updatePaymentStatus');

