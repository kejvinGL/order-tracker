<?php

use Illuminate\Support\Facades\Route;
use KejvinGL\OrderTracker\Controllers\OrderController;

Route::prefix(config('order-tracker.prefix'))->group(function () {

    Route::get('orders', [OrderController::class, 'dataTable']);
    Route::get('export/orders', [OrderController::class, 'export']);
    Route::get('orders', [OrderController::class, 'index']);

    Route::get('create-transaction', [OrderController::class, 'createTransaction'])->name('create.transaction');
    Route::get('process-transaction', [OrderController::class, 'processTransaction'])->name('process.transaction');
    Route::get('success-transaction', [OrderController::class, 'successTransaction'])->name('success.transaction');
    Route::get('cancel-transaction', [OrderController::class, 'cancelTransaction'])->name('cancel.transaction');
});
