<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\GarageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceAppointmentController;
use App\Http\Controllers\ServiceJobCardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PurchaseReturnController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('plans', PlanController::class);

    Route::resource('garages', GarageController::class);

    Route::resource('subscriptions', SubscriptionController::class);

    Route::resource('customers', CustomerController::class);

    Route::resource('vehicles', VehicleController::class);

    Route::resource('staff', StaffController::class);

    Route::resource('categories', ProductCategoryController::class);

    Route::resource('products', ProductController::class);

    Route::resource('suppliers', SupplierController::class);

    Route::resource('purchases', PurchaseController::class);

    Route::resource('purchase-returns', PurchaseReturnController::class);

    Route::resource('sales', SaleController::class);
    
    Route::resource('sale-returns', SaleReturnController::class);

    Route::resource('appointments', ServiceAppointmentController::class);

    Route::resource('job-cards', ServiceJobCardController::class);

    Route::resource('expenses', ExpenseController::class);

    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');

    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::resource('roles', RoleController::class);
});

require __DIR__.'/auth.php';
