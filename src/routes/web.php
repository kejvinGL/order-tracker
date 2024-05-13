<?php

use Illuminate\Support\Facades\Route;
use KejvinGL\OrderTracker\Controllers\OrderController;

Route::prefix(config('order-tracker.prefix'))->middleware(config('order-tracker.middleware'))->group(function () {

    Route::get('orders/datatable', [OrderController::class, 'dataTable']);
    Route::get('export/orders', [OrderController::class, 'export']);
    Route::get('orders', [OrderController::class, 'index']);

    Route::prefix('transaction')->middleware('guest')->group(function () {
        Route::get('create', [OrderController::class, 'createTransaction'])->name('create.transaction');
        Route::get('process', [OrderController::class, 'processTransaction'])->name('process.transaction');
        Route::get('success', [OrderController::class, 'successTransaction'])->name('success.transaction');
        Route::get('cancel', [OrderController::class, 'cancelTransaction'])->name('cancel.transaction');
    });
});
