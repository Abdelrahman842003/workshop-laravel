<?php

use App\Http\Controllers\Reports\AnalyticsReportController;
use Illuminate\Support\Facades\Route;

Route::get('/reports', [AnalyticsReportController::class, 'index'])->name('reports.index');
Route::get('/reports/templates', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'templates'])->name('reports.templates');
Route::get('/reports/generate', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'generate'])->name('reports.generate');
Route::get('/reports/recent', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'recent'])->name('reports.recent');
