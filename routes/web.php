<?php

use App\Http\Controllers\PortalController;
use App\Http\Controllers\MemberPortalController;
use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CommitteePositionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MeetingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'home'])->name('home');
Route::get('/directory', [PortalController::class, 'directory'])->name('directory');

Route::get('/admin/login', [AuthController::class, 'create'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'store'])->name('admin.authenticate');

Route::get('/member/login', [MemberPortalController::class, 'login'])->name('member.login');
Route::post('/member/login', [MemberPortalController::class, 'authenticate'])->name('member.authenticate');

Route::group(['middleware' => 'member.session', 'prefix' => 'member', 'as' => 'member.'], function (): void {
    Route::get('/dashboard', [MemberPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [MemberPortalController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [MemberPortalController::class, 'updateProfile'])->name('profile.update');
    Route::post('/logout', [MemberPortalController::class, 'logout'])->name('logout');
});

Route::group(["middleware" => "admin.session", "prefix" => "admin", "as" => "admin."], function (): void {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');

    Route::resource('members', App\Http\Controllers\MemberController::class);

    Route::resource('committee-positions', CommitteePositionController::class)->except('show');
    Route::resource('meetings', MeetingController::class)->except('show');
    Route::resource('activities', ActivityController::class)->except('show');
});
