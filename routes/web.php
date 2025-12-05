<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\Reports\AnalyticsReportController;
use App\Http\Controllers\Payment\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/reports', [AnalyticsReportController::class, 'index'])->name('reports.index');
Route::get('/reports/templates', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'templates'])->name('reports.templates');
Route::get('/reports/generate', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'generate'])->name('reports.generate');
Route::get('/reports/recent', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'recent'])->name('reports.recent');
Route::get('/reports/download/{id}', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'download'])->name('reports.download');

Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/handle_payment', [PaymentController::class, 'handle_payment'])->name('payment.handle');

Route::resource('products', ProductController::class);
