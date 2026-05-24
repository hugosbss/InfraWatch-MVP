<?php

use App\Models\Monitor;
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

    Route::get('/monitors/{monitor}', function (Monitor $monitor) {
        abort_unless($monitor->user_id === auth()->id(), 404);

        return view('pages.monitors.show', [
            'monitorId' => $monitor->id,
            'monitorName' => $monitor->name,
        ]);
    })->name('monitors.show');

    Route::get('/monitors/{monitor}/edit', function (Monitor $monitor) {
        abort_unless($monitor->user_id === auth()->id(), 404);

        return view('pages.monitors.form', [
            'isEditing' => true,
            'monitorId' => $monitor->id,
        ]);
    })->name('monitors.edit');

    Route::view('/incidents', 'pages.incidents.index')->name('incidents.index');

    Route::view('/settings/alerts', 'pages.settings.alerts')->name('settings.alerts');
});
