<?php

use Illuminate\Support\Facades\Route;
use KejvinGL\OrderTracker\Controllers\OrderController;

Route::prefix(config('order-tracker.prefix'))->middleware(config('order-tracker.middleware'))->group(function () {

    Route::get('datatable', [OrderController::class, 'dataTable']);
    Route::get('xlsx', [OrderController::class, 'exportAsExcel']);
    Route::get('pdf', [OrderController::class, 'exportAsPDF']);
    Route::get('/', [OrderController::class, 'index']);

});
