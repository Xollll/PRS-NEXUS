<?php

use App\Http\Controllers\PortalController;
use App\Http\Controllers\MemberPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'home'])->name('home');
Route::get('/directory', [PortalController::class, 'directory'])->name('directory');

Route::get('/admin/login', [PortalController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [PortalController::class, 'authenticate'])->name('admin.authenticate');

Route::get('/member/login', [MemberPortalController::class, 'login'])->name('member.login');
Route::post('/member/login', [MemberPortalController::class, 'authenticate'])->name('member.authenticate');

Route::group(['middleware' => 'member.session', 'prefix' => 'member', 'as' => 'member.'], function (): void {
    Route::get('/dashboard', [MemberPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [MemberPortalController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [MemberPortalController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [MemberPortalController::class, 'logout'])->name('logout');
});

Route::group(["middleware" => "admin.session", "prefix" => "admin", "as" => "admin."], function (): void {
    Route::get('/dashboard', [PortalController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [PortalController::class, 'logout'])->name('logout');

    Route::resource('members', App\Http\Controllers\MemberController::class);

    Route::post('/committee-positions', [PortalController::class, 'storeCommitteePosition'])->name('committee-positions.store');
    Route::get('/committee-positions/{committeePosition}/edit', [PortalController::class, 'editCommitteePosition'])->name('committee-positions.edit');
    Route::put('/committee-positions/{committeePosition}', [PortalController::class, 'updateCommitteePosition'])->name('committee-positions.update');
    Route::delete('/committee-positions/{committeePosition}', [PortalController::class, 'destroyCommitteePosition'])->name('committee-positions.destroy');

    Route::post('/meetings', [PortalController::class, 'storeMeeting'])->name('meetings.store');
    Route::get('/meetings/{meeting}/edit', [PortalController::class, 'editMeeting'])->name('meetings.edit');
    Route::put('/meetings/{meeting}', [PortalController::class, 'updateMeeting'])->name('meetings.update');
    Route::delete('/meetings/{meeting}', [PortalController::class, 'destroyMeeting'])->name('meetings.destroy');

    Route::post('/activities', [PortalController::class, 'storeActivity'])->name('activities.store');
    Route::get('/activities/{activity}/edit', [PortalController::class, 'editActivity'])->name('activities.edit');
    Route::put('/activities/{activity}', [PortalController::class, 'updateActivity'])->name('activities.update');
    Route::delete('/activities/{activity}', [PortalController::class, 'destroyActivity'])->name('activities.destroy');
});
