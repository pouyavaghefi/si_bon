<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ConfigurationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductCategoryController;

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {

       /*
       |------------------------------------------------------------------
       | Products
       |------------------------------------------------------------------
       */

        Route::prefix('categories')
            ->name('categories.')
            ->group(function () {

                Route::get('/', [ProductCategoryController::class, 'index'])
                    ->name('index');

                Route::get('/create', [ProductCategoryController::class, 'create'])
                    ->name('create');

                Route::post('/store', [ProductCategoryController::class, 'store'])
                    ->name('store');

                Route::get('/edit/{category}', [ProductCategoryController::class, 'edit'])
                    ->name('edit');

                Route::post('/update/{category}', [ProductCategoryController::class, 'update'])
                    ->name('update');

                Route::delete('/delete/{category}', [ProductCategoryController::class, 'destroy'])
                    ->name('destroy');

            });

        Route::prefix('products')
            ->name('products.')
            ->group(function () {
                Route::get('/', [ProductController::class, 'index'])
                    ->name('index');

                Route::get('/create-simple', [ProductController::class, 'createSimple'])
                    ->name('create');

                Route::post('/store', [ProductController::class, 'store'])
                    ->name('store');

                Route::get('/edit/{product}', [ProductController::class, 'edit'])
                    ->name('edit');

                Route::post('/update/{product}', [ProductController::class, 'update'])
                    ->name('update');

                Route::delete('/delete/{product}', [ProductController::class, 'destroy'])
                    ->name('destroy');

                Route::get('/create-taki', [ProductController::class, 'createTaki'])
                    ->name('createTaki');

                Route::post('/store-taki', [ProductController::class, 'storeTaki'])
                    ->name('storeTaki');

                Route::get('/edit-taki/{product}', [ProductController::class, 'editTaki'])
                    ->name('editTaki');

                Route::post('/update-taki/{product}', [ProductController::class, 'updateTaki'])
                    ->name('updateTaki');
            });

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
