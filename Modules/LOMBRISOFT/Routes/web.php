<?php

use Modules\LOMBRISOFT\Http\Controllers\WormBedController;
use Modules\LOMBRISOFT\Http\Controllers\MaterialController;
use Modules\LOMBRISOFT\Http\Controllers\MaterialMovementController;
use Modules\LOMBRISOFT\Http\Controllers\BedActivityController;
use Modules\LOMBRISOFT\Http\Controllers\ReportController;
use Modules\LOMBRISOFT\Http\Controllers\ActivityAlertController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


// Rutas principales y camas
Route::middleware(['lang'])->prefix('lombrisoft')->group(function () {

    Route::get('/index', 'LOMBRISOFTController@index')->name('cefa.lombrisoft.index');
    Route::get('/admin/welcome', 'LOMBRISOFTController@admin')->name('lombrisoft.admin.welcome');
    Route::get('/welcome', 'LOMBRISOFTController@welcome')->name('lombrisoft.welcome');
    Route::get('/intern/paneli', 'LOMBRISOFTController@intern')->name('lombrisoft.intern.paneli');

    // Gestión de camas
    Route::prefix('admin/camas')->group(function () {
        Route::get('/', [WormBedController::class, 'index'])->name('lombrisoft.admin.camas.index');
        Route::get('/crear', [WormBedController::class, 'create'])->name('lombrisoft.admin.camas.create');
        Route::post('/store', [WormBedController::class, 'store'])->name('lombrisoft.admin.camas.store');
        Route::get('/{id}', [WormBedController::class, 'show'])->name('lombrisoft.admin.camas.show');
        Route::get('/{id}/editar', [WormBedController::class, 'edit'])->name('lombrisoft.admin.camas.edit');
        Route::put('/{id}', [WormBedController::class, 'update'])->name('lombrisoft.admin.camas.update');
        Route::delete('/{id}', [WormBedController::class, 'destroy'])->name('lombrisoft.admin.camas.destroy');
    });

    // Gestión de alertas
    Route::prefix('admin/activity-alerts')->group(function () {
        Route::get('/', [ActivityAlertController::class, 'index'])->name('lombrisoft.admin.activity_alerts.index');
        Route::get('/create', [ActivityAlertController::class, 'create'])->name('lombrisoft.admin.activity_alerts.create');
        Route::post('/store', [ActivityAlertController::class, 'store'])->name('lombrisoft.admin.activity_alerts.store');
        Route::get('/{id}', [ActivityAlertController::class, 'show'])->name('lombrisoft.admin.activity_alerts.show');
        Route::get('/{id}/edit', [ActivityAlertController::class, 'edit'])->name('lombrisoft.admin.activity_alerts.edit');
        Route::put('/{id}', [ActivityAlertController::class, 'update'])->name('lombrisoft.admin.activity_alerts.update');
        Route::delete('/{id}', [ActivityAlertController::class, 'destroy'])->name('lombrisoft.admin.activity_alerts.destroy');
    });

});

// Bed activities
Route::prefix('admin/bed_activities')->group(function () {
    Route::get('/', [BedActivityController::class, 'index'])->name('lombrisoft.admin.bed_activities.index');
    Route::get('/create', [BedActivityController::class, 'create'])->name('lombrisoft.admin.bed_activities.create');
    Route::post('/store', [BedActivityController::class, 'store'])->name('lombrisoft.admin.bed_activities.store');
    Route::get('/{id}', [BedActivityController::class, 'show'])->name('lombrisoft.admin.bed_activities.show');
    Route::put('/{id}', [BedActivityController::class, 'update'])->name('lombrisoft.admin.bed_activities.update');
    Route::delete('/{id}', [BedActivityController::class, 'destroy'])->name('lombrisoft.admin.bed_activities.destroy');
});

// Reportes
Route::middleware(['web'])->group(function () {
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('reports/word', [ReportController::class, 'exportWord'])->name('reports.word');
    Route::post('reports', [ReportController::class, 'store'])->name('reports.store');
});
Route::prefix('lombrisoft')->group(function () {
    Route::prefix('admin/activity-alerts')->group(function () {
        Route::get('/send-pending', [ActivityAlertController::class, 'sendPendingAlertsEmail'])
            ->name('lombrisoft.admin.activity_alerts.send');
    });
});
Route::get('/prueba-correo-html', function () {
    $data = [
        'title' => '¡Hola desde Laravel!',
        'body' => 'Este es un correo de prueba con HTML, enviado desde tu Laravel usando Gmail real.'
    ];

    Mail::send([], $data, function ($message) use ($data) {
        $message->to('ardilanicolas71@gmail.com')
                ->subject('Prueba de correo HTML Laravel')
                ->from('ardilanicolas71@gmail.com', 'Laravel Test')
                ->setBody(
                    "<h1>{$data['title']}</h1><p>{$data['body']}</p>",
                    'text/html'
                );
    });

    return 'Correo HTML enviado. Revisa tu Gmail (incluido Spam).';
});




