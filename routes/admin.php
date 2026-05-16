<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ConfigurationController;

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::middleware('guest')->group(function () {

            Route::get('login', [LoginController::class, 'showLogin'])
                ->name('login');

            Route::post('login', [LoginController::class, 'doLogin'])
                ->name('login.submit');

        });

        Route::middleware('auth')->group(function () {

            Route::get('dashboard', [DashboardController::class, 'index'])
                ->name('dashboard');

            Route::get('profile', [ProfileController::class, 'index'])
                ->name('profile');

            Route::get('configuration', [ConfigurationController::class, 'index'])
                ->name('configuration');

            Route::post('config/update', [ConfigurationController::class, 'update'])
                ->name('config.update');

            Route::get('settings', [SettingsController::class, 'index'])
                ->name('settings');

            Route::post('settings/basic', [SettingsController::class, 'updateBasic'])
                ->name('settings.basic');

            Route::post('settings/password', [SettingsController::class, 'updatePassword'])
                ->name('settings.password');

            Route::post('settings/avatar', [SettingsController::class, 'updateAvatar'])
                ->name('settings.avatar');

            Route::post('notifications/read-all', [DashboardController::class, 'readAllNotifications'])
                ->name('notifications.readAll');

            Route::post('logout', [LoginController::class, 'logout'])
                ->name('logout');

        });


    });
