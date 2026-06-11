<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ReportController::class, 'index'])->name('dashboard');

    Route::middleware('vendeur')->group(function () {
        Route::resource('orders', OrderController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('/orders/export/pdf', [OrderController::class, 'exportPDF'])->name('orders.export.pdf');
        Route::get('/orders/export/csv', [OrderController::class, 'exportCSV'])->name('orders.export.csv');
        Route::resource('deliveries', DeliveryController::class)->only(['index']);
        Route::post('/deliveries/{delivery}/status', [DeliveryController::class, 'updateStatus'])->name('deliveries.updateStatus');
        Route::get('/deliveries/daily-sheet', [DeliveryController::class, 'dailyDeliverySheet'])->name('deliveries.daily-sheet');
        Route::get('/deliveries/past-sheets', [DeliveryController::class, 'pastDeliverySheets'])->name('deliveries.past-sheets');
        Route::resource('expenses', \App\Http\Controllers\ExpenseController::class);
        Route::get('/expenses/export/pdf', [\App\Http\Controllers\ExpenseController::class, 'exportPDF'])->name('expenses.export.pdf');
        Route::get('/expenses/export/csv', [\App\Http\Controllers\ExpenseController::class, 'exportCSV'])->name('expenses.export.csv');
    });

    Route::middleware('admin')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
