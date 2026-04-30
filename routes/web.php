<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\SecurityController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Welcome'))->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
});

Route::middleware('auth')->group(function (): void {
    Route::delete('user', [ProfileController::class, 'destroy'])->name('user.destroy');

    Route::redirect('settings', '/settings/profile');
    Route::get('settings/profile', [ProfileController::class, 'edit'])->name('user-profile.edit');
    Route::patch('settings/profile', [ProfileController::class, 'update'])->name('user-profile.update');

    Route::get('settings/password', [SecurityController::class, 'edit'])->name('password.edit');
    Route::put('settings/password', [SecurityController::class, 'update'])
        ->middleware('throttle:6,1')
        ->name('password.update');

    Route::get('settings/appearance', fn () => Inertia::render('settings/Appearance'))->name('appearance.edit');

    Route::get('settings/two-factor', [SecurityController::class, 'edit'])
        ->name('two-factor.show');
});

Route::middleware('guest')->group(function (): void {
    Route::resource('register', RegisterController::class)
        ->only(['index', 'store'])
        ->names(['index' => 'register', 'store' => 'register.store']);

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');

    Route::resource('forgot-password', PasswordResetLinkController::class)
        ->only(['index', 'store'])
        ->names(['index' => 'password.request', 'store' => 'password.email']);

    Route::resource('login', LoginController::class)
        ->only(['index', 'store'])
        ->names(['index' => 'login', 'store' => 'login.store']);
});

Route::middleware('auth')->group(function (): void {
    Route::get('verify-email', [EmailVerificationController::class, 'index'])
        ->name('verification.notice');
    Route::post('email/verification-notification', EmailVerificationNotificationController::class)
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'update'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('logout', LogoutController::class)->name('logout');
});
