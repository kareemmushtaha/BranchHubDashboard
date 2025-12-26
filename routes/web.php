<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SessionPaymentController;
use App\Http\Controllers\DrinkInvoiceController;
use App\Http\Controllers\DrinkInvoiceItemController;
use App\Http\Controllers\DrinkController;
use App\Http\Controllers\SessionDrinkController;
use App\Http\Controllers\CalendarNoteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SessionAuditController;
use App\Http\Controllers\SessionPriceController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BookingRequestController;
use App\Http\Controllers\ElectricityMeterReadingController;
use App\Http\Controllers\EmployeeSalaryController;
use App\Http\Controllers\EmployeeNoteController;
use App\Http\Controllers\RolePermissionController;


// Branch Hub Landing Page (for non-authenticated users)
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('branchhub-landing');
})->name('branchhub.landing');

// Welcome Page (alternative welcome page)
Route::get('/welcome', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

// Advanced Landing Page
Route::get('/landing-advanced', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('landing-advanced');
})->name('landing.advanced');

// Simple Landing Page
Route::get('/landing-simple', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('landing-simple');
})->name('landing.simple');

// Branch Hub Landing Page (alternative route)
Route::get('/branchhub', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('branchhub-landing');
})->name('branchhub');

// Branch Hub Booking Form
Route::get('/booking', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('booking-form');
})->name('booking.form');

// Authentication Routes
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Profile Routes
Route::get('profile', [AuthController::class, 'showProfile'])->name('profile');
Route::put('profile', [AuthController::class, 'updateProfile'])->name('profile.update');
Route::post('profile/change-password', [AuthController::class, 'changePassword'])->name('profile.change-password');

// Protected Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/real-time', function() {
    return view('dashboard.real-time');
})->name('dashboard.real-time');

// Users Routes
Route::resource('users', UserController::class)->middleware('permission:view users|show user details|create users|edit users|delete users');
Route::get('users-monthly', [UserController::class, 'monthly'])->name('users.monthly')->middleware('permission:view users');
Route::get('users-hourly', [UserController::class, 'hourly'])->name('users.hourly')->middleware('permission:view users');
Route::get('users-prepaid', [UserController::class, 'prepaid'])->name('users.prepaid')->middleware('permission:view users');
Route::post('users/{user}/charge-wallet', [UserController::class, 'chargeWallet'])->name('users.charge-wallet');
Route::post('users/{user}/deduct-wallet', [UserController::class, 'deductWallet'])->name('users.deduct-wallet');
Route::post('users/{user}/add-debt', [UserController::class, 'addDebt'])->name('users.add-debt');
Route::delete('users/{user}/wallet-transactions/delete-all', [UserController::class, 'deleteAllTransactions'])->name('users.wallet-transactions.delete-all');
Route::put('users/{user}/wallet-transactions/{transaction}', [UserController::class, 'updateTransaction'])->name('users.wallet-transactions.update');
Route::get('users/{user}/wallet-history', [UserController::class, 'walletHistory'])->name('users.wallet-history');

// Soft Delete Routes for Users
Route::get('users-trashed', [UserController::class, 'trashed'])->name('users.trashed');
Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');

// Bulk Actions Routes for Users
Route::post('users/bulk-destroy', [UserController::class, 'bulkDestroy'])->name('users.bulk-destroy');
Route::post('users/bulk-restore', [UserController::class, 'bulkRestore'])->name('users.bulk-restore');
Route::post('users/bulk-force-delete', [UserController::class, 'bulkForceDelete'])->name('users.bulk-force-delete');

// Drink Invoices Routes
Route::resource('drink-invoices', DrinkInvoiceController::class);
Route::get('drink-invoices-pending', [DrinkInvoiceController::class, 'pending'])->name('drink-invoices.pending');
Route::post('drink-invoices/{drinkInvoice}/add-drink', [DrinkInvoiceController::class, 'addDrink'])->name('drink-invoices.add-drink');
Route::delete('drink-invoices/{drinkInvoice}/items/{item}', [DrinkInvoiceController::class, 'removeDrink'])->name('drink-invoices.remove-drink');
Route::put('drink-invoices/{drinkInvoice}/items/{item}/update-date', [DrinkInvoiceController::class, 'updateDrinkDate'])->name('drink-invoices.update-drink-date');
Route::put('drink-invoices/{drinkInvoice}/items/{item}/update-price', [DrinkInvoiceController::class, 'updateDrinkPrice'])->name('drink-invoices.update-drink-price');
Route::get('drink-invoices/{drinkInvoice}/invoice', [DrinkInvoiceController::class, 'generateInvoice'])->name('drink-invoices.invoice');
Route::get('drink-invoices/{drinkInvoice}/invoice/show', [DrinkInvoiceController::class, 'showInvoice'])->name('drink-invoices.invoice.show');

// Drink Invoice Items Routes
Route::get('drink-invoice-items', [DrinkInvoiceItemController::class, 'index'])->name('drink-invoice-items.index');

// Session Drinks Routes
Route::get('session-drinks', [SessionDrinkController::class, 'index'])->name('session-drinks.index');

// Sessions Routes
Route::resource('sessions', SessionController::class)->middleware('permission:view sessions|create sessions|edit sessions|delete sessions');
Route::get('sessions-overdue', [SessionController::class, 'overdue'])->name('sessions.overdue');
Route::post('users/{user}/create-session', [SessionController::class, 'createForUser'])->name('users.create-session');
Route::post('sessions/{session}/end', [SessionController::class, 'endSession'])->name('sessions.end');
Route::post('sessions/{session}/cancel', [SessionController::class, 'cancelSession'])->name('sessions.cancel');
Route::post('sessions/{session}/complete-and-deduct', [SessionController::class, 'completeAndDeduct'])->name('sessions.complete-and-deduct');
Route::post('sessions/{session}/add-drink', [SessionController::class, 'addDrink'])->name('sessions.add-drink');
Route::put('sessions/{session}/drinks/{sessionDrink}/update-date', [SessionController::class, 'updateDrinkDate'])->name('sessions.update-drink-date');
Route::put('sessions/{session}/drinks/{sessionDrink}/update-price', [SessionController::class, 'updateDrinkPrice'])->name('sessions.update-drink-price');
Route::delete('sessions/{session}/drinks/{sessionDrink}', [SessionController::class, 'removeDrink'])->name('sessions.remove-drink');
Route::post('sessions/{session}/add-overtime', [SessionController::class, 'addOvertime'])->name('sessions.add-overtime');
Route::put('sessions/{session}/update-overtime-rate', [SessionController::class, 'updateOvertimeRate'])->name('sessions.update-overtime-rate');
Route::put('sessions/{session}/overtimes/{overtime}', [SessionController::class, 'updateOvertime'])->name('sessions.update-overtime');
Route::delete('sessions/{session}/overtimes/{overtime}', [SessionController::class, 'removeOvertime'])->name('sessions.remove-overtime');


// Soft Delete Routes for Sessions
Route::get('sessions-trashed', [SessionController::class, 'trashed'])->name('sessions.trashed')->middleware('permission:view trashed sessions');
Route::post('sessions/{id}/restore', [SessionController::class, 'restore'])->name('sessions.restore');
Route::delete('sessions/{id}/force-delete', [SessionController::class, 'forceDelete'])->name('sessions.force-delete');

// Bulk Actions Routes for Sessions
Route::post('sessions/bulk-destroy', [SessionController::class, 'bulkDestroy'])->name('sessions.bulk-destroy');
Route::post('sessions/bulk-restore', [SessionController::class, 'bulkRestore'])->name('sessions.bulk-restore');
Route::post('sessions/bulk-force-delete', [SessionController::class, 'bulkForceDelete'])->name('sessions.bulk-force-delete');


// Session Payments Routes
Route::resource('session-payments', SessionPaymentController::class)->middleware('permission:view session payments|create session payments|edit session payments|delete session payments');
Route::get('session-payments/{sessionPayment}/invoice', [SessionPaymentController::class, 'generateInvoice'])->name('session-payments.invoice');
Route::get('session-payments/{sessionPayment}/invoice/show', [SessionPaymentController::class, 'showInvoice'])->name('session-payments.invoice.show');



// Drinks Routes
Route::resource('drinks', DrinkController::class)->middleware('permission:view drinks|create drinks|edit drinks|delete drinks');

// Calendar Notes Routes
Route::get('calendar-notes', [CalendarNoteController::class, 'index'])->name('calendar-notes.index');
Route::post('calendar-notes', [CalendarNoteController::class, 'store'])->name('calendar-notes.store');
Route::put('calendar-notes/{calendarNote}', [CalendarNoteController::class, 'update'])->name('calendar-notes.update');
Route::delete('calendar-notes/{calendarNote}', [CalendarNoteController::class, 'destroy'])->name('calendar-notes.destroy');

// Employee Notes Routes
Route::get('employee-notes', [EmployeeNoteController::class, 'index'])->name('employee-notes.index');
Route::post('employee-notes', [EmployeeNoteController::class, 'store'])->name('employee-notes.store');
Route::put('employee-notes/{employeeNote}', [EmployeeNoteController::class, 'update'])->name('employee-notes.update');
Route::delete('employee-notes/{employeeNote}', [EmployeeNoteController::class, 'destroy'])->name('employee-notes.destroy');

// Reports Routes
Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('reports/revenue', [ReportController::class, 'revenue'])->name('reports.revenue');
Route::get('reports/users', [ReportController::class, 'users'])->name('reports.users');
Route::get('reports/drinks', [ReportController::class, 'drinks'])->name('reports.drinks');

// Audit Routes
Route::get('sessions/{session}/audit', [SessionAuditController::class, 'show'])->name('sessions.audit');
Route::get('audit', [SessionAuditController::class, 'index'])->name('audit.index');
Route::get('audit/export', [SessionAuditController::class, 'export'])->name('audit.export');

// Dynamic Pricing Routes
Route::put('sessions/{session}/update-internet-cost', [SessionPriceController::class, 'updateInternetCost'])->name('sessions.update-internet-cost');
Route::post('sessions/{session}/update-internet-cost-form', [SessionPriceController::class, 'updateInternetCostForm'])->name('sessions.update-internet-cost-form');
Route::get('sessions/{session}/pricing', [SessionPriceController::class, 'getSessionPricing'])->name('sessions.pricing');
Route::post('sessions/update-all-pricing', [SessionPriceController::class, 'updateAllActiveSessions'])->name('sessions.update-all-pricing');

// Session Start Time Update Route
Route::put('sessions/{session}/update-start-time', [SessionController::class, 'updateStartTime'])->name('sessions.update-start-time');
Route::put('sessions/{session}/update-end-time', [SessionController::class, 'updateEndTime'])->name('sessions.update-end-time');
Route::get('sessions/real-time-stats', [SessionPriceController::class, 'getRealTimePricingStats'])->name('sessions.real-time-stats');

// Subscription Session Management Routes
Route::put('sessions/{session}/update-expected-end-date', [SessionController::class, 'updateExpectedEndDate'])->name('sessions.update-expected-end-date');
Route::post('sessions/{session}/end-subscription', [SessionController::class, 'endSubscriptionSession'])->name('sessions.end-subscription');

// Session Note Update Route (available for all sessions including completed)
Route::put('sessions/{session}/update-note', [SessionController::class, 'updateNote'])->name('sessions.update-note');

// Session Pause/Resume Routes
Route::post('sessions/{session}/pause', [SessionController::class, 'pauseSession'])->name('sessions.pause');
Route::post('sessions/{session}/resume', [SessionController::class, 'resumeSession'])->name('sessions.resume');

// Expenses Routes
Route::resource('expenses', ExpenseController::class);

// Employee Salaries Routes
Route::resource('employee-salaries', EmployeeSalaryController::class);

// Electricity Meter Readings Routes
Route::resource('electricity-meter-readings', ElectricityMeterReadingController::class);

// Booking Requests Routes (Admin only) - excluding store method
Route::resource('booking-requests', BookingRequestController::class)->except(['store']);
Route::put('booking-requests/{id}/status', [BookingRequestController::class, 'updateStatus'])->name('booking-requests.update-status');

// Roles & Permissions Routes
Route::resource('roles', RolePermissionController::class)->except(['show', 'create']);

});

// Public booking request submission (no auth required)
Route::post('booking-requests', [BookingRequestController::class, 'store'])->name('booking-requests.store');
