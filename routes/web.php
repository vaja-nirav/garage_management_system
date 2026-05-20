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
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\InspectionChecklistController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
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

    // Subscription & Administration
    Route::resource('plans', PlanController::class)->middleware('permission:view plans');
    Route::resource('garages', GarageController::class)->middleware('permission:view garages');
    Route::resource('subscriptions', SubscriptionController::class)->middleware('permission:view subscriptions');

    // CRM & Staff
    Route::resource('customers', CustomerController::class)->middleware('permission:view customers');
    Route::resource('vehicles', VehicleController::class)->middleware('permission:view vehicles');
    Route::resource('staff', StaffController::class)->middleware('permission:view staff');

    // Inventory
    Route::resource('categories', ProductCategoryController::class)->middleware('permission:view categories');
    Route::resource('products', ProductController::class)->middleware('permission:view products');
    Route::resource('suppliers', SupplierController::class)->middleware('permission:view suppliers');

    // Operations
    Route::resource('purchases', PurchaseController::class)->middleware('permission:view purchases');
    Route::get('purchase-returns/get-items/{purchase}', [PurchaseReturnController::class, 'getPurchaseItems'])->name('purchase-returns.get-items')->middleware('permission:view purchase_returns');
    Route::resource('purchase-returns', PurchaseReturnController::class)->middleware('permission:view purchase_returns');
    Route::resource('sales', SaleController::class)->middleware('permission:view sales');
    Route::get('sale-returns/get-items/{sale}', [SaleReturnController::class, 'getSaleItems'])->name('sale-returns.get-items')->middleware('permission:view sale_returns');
    Route::resource('sale-returns', SaleReturnController::class)->middleware('permission:view sale_returns');
    Route::resource('appointments', ServiceAppointmentController::class)->middleware('permission:view appointments');
    Route::resource('inspection-checklists', InspectionChecklistController::class);
    Route::resource('quotations', QuotationController::class);
    Route::post('quotations/{quotation}/convert', [QuotationController::class, 'convertToJobCard'])->name('quotations.convert');
    Route::resource('job-cards', ServiceJobCardController::class)->middleware('permission:view job_cards');
    Route::post('job-cards/{jobCard}/checkout', [ServiceJobCardController::class, 'checkout'])->name('job-cards.checkout')->middleware('permission:view job_cards');
    Route::get('job-cards/{jobCard}/print', [ServiceJobCardController::class, 'print'])->name('job-cards.print')->middleware('permission:view job_cards');
    Route::post('job-cards/{jobCard}/add-item', [ServiceJobCardController::class, 'addItem'])->name('job-cards.addItem')->middleware('permission:view job_cards');
    Route::delete('job-cards/items/{item}', [ServiceJobCardController::class, 'destroyItem'])->name('job-cards.items.destroy')->middleware('permission:view job_cards');

    // Financials & System
    Route::resource('expenses', ExpenseController::class)->middleware('permission:view expenses');
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index')->middleware('permission:view reports');
    Route::get('reports/pdf', [ReportController::class, 'downloadPdf'])->name('reports.pdf')->middleware('permission:view reports');
    Route::get('reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel')->middleware('permission:view reports');
    Route::resource('roles', RoleController::class)->middleware('permission:view roles');
});

require __DIR__.'/auth.php';
