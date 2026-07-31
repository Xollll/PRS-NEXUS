<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'home'])->name('home');
Route::get('/directory', [PortalController::class, 'directory'])->name('directory');

Route::get('/admin/login', [PortalController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [PortalController::class, 'authenticate'])->name('admin.authenticate');

Route::group(["middleware" => "admin.session", "prefix" => "admin", "as" => "admin."], function (): void {
    Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

    Route::resource('members', App\Http\Controllers\MemberController::class);

    Route::post('/committee-positions', [PortalController::class, 'storeCommitteePosition'])->name('committee-positions.store');
    Route::delete('/committee-positions/{committeePosition}', [PortalController::class, 'destroyCommitteePosition'])->name('committee-positions.destroy');

    Route::post('/meetings', [PortalController::class, 'storeMeeting'])->name('meetings.store');
    Route::delete('/meetings/{meeting}', [PortalController::class, 'destroyMeeting'])->name('meetings.destroy');

    Route::post('/activities', [PortalController::class, 'storeActivity'])->name('activities.store');
    Route::delete('/activities/{activity}', [PortalController::class, 'destroyActivity'])->name('activities.destroy');
});
