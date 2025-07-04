<?php

use Modules\LOMBRISOFT\Http\Controllers\WormBedController;
use Modules\LOMBRISOFT\Http\Controllers\MaterialController;
use Modules\LOMBRISOFT\Http\Controllers\MaterialMovementController;

Route::middleware(['lang'])->prefix('lombrisoft')->group(function () {

    // Rutas principales
    Route::get('/index', 'LOMBRISOFTController@index')->name('cefa.lombrisoft.index');
    Route::get('/admin/welcome', 'LOMBRISOFTController@admin')->name('lombrisoft.admin.welcome');
    Route::get('/welcome', 'LOMBRISOFTController@welcome')->name('lombrisoft.welcome');
    Route::get('/intern/paneli', 'LOMBRISOFTController@intern')->name('lombrisoft.intern.paneli');

  // Rutas para gestión de camas
    Route::get('admin/camas', [WormBedController::class, 'index'])->name('lombrisoft.admin.camas.index');
    Route::get('admin/camas/crear', [WormBedController::class, 'create'])->name('lombrisoft.admin.camas.create');
    Route::post('admin/camas/store', [WormBedController::class, 'store'])->name('lombrisoft.admin.camas.store');
    Route::get('admin/camas/{id}', [WormBedController::class, 'show'])->name('lombrisoft.admin.camas.show');
    Route::get('admin/camas/{id}/editar', [WormBedController::class, 'edit'])->name('lombrisoft.admin.camas.edit');
    Route::put('admin/camas/{id}', [WormBedController::class, 'update'])->name('lombrisoft.admin.camas.update');
    Route::delete('admin/camas/{id}', [WormBedController::class, 'destroy'])->name('lombrisoft.admin.camas.destroy');
    // Rutas para gestión de materiales
 Route::prefix('admin/materials')->group(function () {
        Route::get('/', [MaterialController::class, 'index'])->name('lombrisoft.admin.materials.index');
        Route::get('/crear', [MaterialController::class, 'create'])->name('lombrisoft.admin.materials.create');
        Route::post('/store', [MaterialController::class, 'store'])->name('lombrisoft.admin.materials.store');
        Route::get('/{id}', [MaterialController::class, 'show'])->name('lombrisoft.admin.materials.show');
        Route::get('/{id}/editar', [MaterialController::class, 'edit'])->name('lombrisoft.admin.materials.edit');
        Route::put('/{id}', [MaterialController::class, 'update'])->name('lombrisoft.admin.materials.update');
        Route::delete('/{id}', [MaterialController::class, 'destroy'])->name('lombrisoft.admin.materials.destroy');
    });
    Route::prefix('admin/movements')->group(function () {
    Route::get('/', [MaterialMovementController::class, 'index'])->name('lombrisoft.admin.movements.index');
    Route::get('/crear', [MaterialMovementController::class, 'create'])->name('lombrisoft.admin.movements.create');
    Route::post('/store', [MaterialMovementController::class, 'store'])->name('lombrisoft.admin.movements.store');
    Route::get('/{id}', [MaterialMovementController::class, 'show'])->name('lombrisoft.admin.movements.show');
    Route::delete('/{id}', [MaterialMovementController::class, 'destroy'])->name('lombrisoft.admin.movements.destroy');
});
});
