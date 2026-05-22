<?php

use App\Support\MonitoringDemoData;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::view('/dashboard', 'pages.dashboard')->name('dashboard');

    Route::view('/monitors', 'pages.monitors.index')->name('monitors.index');

    Route::get('/monitors/create', function () {
        return view('pages.monitors.form', [
            'isEditing' => false,
            'monitorId' => null,
        ]);
    })->name('monitors.create');

    Route::get('/monitors/{monitor}', function (string $monitor) {
        $data = MonitoringDemoData::findMonitor($monitor);

        if ($data === null) {
            abort(404);
        }

        return view('pages.monitors.show', [
            'monitorId' => $monitor,
            'monitorName' => $data['name'],
        ]);
    })->name('monitors.show');

    Route::get('/monitors/{monitor}/edit', function (string $monitor) {
        if (MonitoringDemoData::findMonitor($monitor) === null) {
            abort(404);
        }

        return view('pages.monitors.form', [
            'isEditing' => true,
            'monitorId' => $monitor,
        ]);
    })->name('monitors.edit');

    Route::view('/incidents', 'pages.incidents.index')->name('incidents.index');

    Route::view('/settings/alerts', 'pages.settings.alerts')->name('settings.alerts');
});
