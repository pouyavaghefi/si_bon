<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\VerifyController;

Route::prefix('auth')
    ->name('auth.')
    ->group(function () {

        Route::middleware('guest')->group(function () {

            Route::get('/login', [LoginController::class, 'showLogin'])
                ->name('login');

            Route::post('/login', [LoginController::class, 'doLogin'])
                ->name('submit.login');

            Route::get('/register', [RegisterController::class, 'showRegister'])
                ->name('register');

            Route::post('/register', [RegisterController::class, 'doRegister'])
                ->name('submit.register');

            Route::get('/forgot-password', [ForgotController::class, 'showForgot'])
                ->name('forgot-password');

            Route::post('/forgot-password', [ForgotController::class, 'doForgot'])
                ->name('submit.forgot-password');

            Route::get('/verify', [VerifyController::class, 'showVerify'])
                ->name('verify');

            Route::post('/verify', [VerifyController::class, 'doVerify'])
                ->name('verify.submit');

            Route::post('/resend-code', [VerifyController::class, 'resendCode'])
                ->name('resend-code');

        });

        Route::post('/logout', [LoginController::class, 'logout'])
            ->name('logout')
            ->middleware('auth');
    });
