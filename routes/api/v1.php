<?php

use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\EmployeeController;
use App\Http\Controllers\Api\v1\ExportImportController;
use App\Http\Controllers\Api\V1\WorkStatusController;
use Illuminate\Support\Facades\Route;

Route::controller(EmployeeController::class)
    ->prefix('employees')
    ->group(function () {
        Route::get('', 'index')->name('employee::index');
        Route::get('/find/{id}', 'find')->name('employee::find');
        Route::post('', 'store')->name('employee::store');
        Route::put('/update/{id}', 'update')->name('employee::update');
        Route::delete('/delete/{id}', 'delete')->name('employee::delete');
        Route::get('/count', 'count')->name('employee::count');
    });

Route::controller(WorkStatusController::class)
    ->prefix('work-statuses')
    ->group(function () {
        Route::get('', 'index')->name('work-status::index');
    });

Route::controller(DepartmentController::class)
    ->prefix('departments')
    ->group(function () {
        Route::get('', 'index')->name('department::index');
    });

Route::controller(ExportImportController::class)
    ->prefix('export-imports')
    ->group(function () {
        Route::post('import', 'importExcel');
        Route::get('export-excel', 'exportExcel');
        Route::get('export-pdf', 'exportPdf');
    });
