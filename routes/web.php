<?php

use App\Http\Controllers\Reports\AnalyticsReportController;
use Illuminate\Support\Facades\Route;

Route::get('/reports', [AnalyticsReportController::class, 'index'])->name('reports.index');
Route::get('/reports/templates', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'templates'])->name('reports.templates');
Route::get('/reports/generate', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'generate'])->name('reports.generate');
Route::get('/reports/recent', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'recent'])->name('reports.recent');
Route::get('/reports/download/{id}', [App\Http\Controllers\Reports\AnalyticsReportController::class, 'download'])->name('reports.download');

use App\Http\Controllers\Integrations\IntegrationController;

Route::resource('integrations', IntegrationController::class);
Route::get('integrations/{integration}/logs', [IntegrationController::class, 'logs'])->name('integrations.logs');

