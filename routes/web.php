<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\LandingController;
use App\Http\Controllers\Frontend\ProfileController;

Route::prefix('/')
    ->name('front.')
    ->group(function () {

        Route::get('/', [LandingController::class, 'index'])->name('landing');

        Route::middleware('auth')
            ->prefix('user')
            ->name('user.')
            ->group(function () {

                Route::get('/profile', [ProfileController::class, 'showProfile'])
                    ->name('profile');

                Route::put('/profile/update', [ProfileController::class, 'updateProfile'])
                    ->name('profile.update');

                Route::get('/wallet', [ProfileController::class, 'showWallet'])
                    ->name('wallet');

                Route::post('/wallet/deposit', [ProfileController::class, 'depositWallet'])
                    ->name('wallet.deposit');

                /*
                |--------------------------------------------------------------------------
                | Orders
                |--------------------------------------------------------------------------
                */

                Route::get('/orders', [ProfileController::class, 'allOrders'])
                    ->name('orders');

                Route::get('/orders/new', [ProfileController::class, 'newOrders'])
                    ->name('orders.new');

                Route::get('/orders/ready', [ProfileController::class, 'readyOrders'])
                    ->name('orders.ready');

                Route::get('/orders/completed', [ProfileController::class, 'completedOrders'])
                    ->name('orders.completed');

                /*
                |--------------------------------------------------------------------------
                | Financial
                |--------------------------------------------------------------------------
                */

                Route::get('/finance', [ProfileController::class, 'finance'])
                    ->name('finance');

                Route::get('/deposits', [ProfileController::class, 'deposits'])
                    ->name('deposits');

                Route::get('/credits', [ProfileController::class, 'credits'])
                    ->name('credits');

                Route::get('/cashback', [ProfileController::class, 'cashback'])
                    ->name('cashback');

                /*
                |--------------------------------------------------------------------------
                | User Panel
                |--------------------------------------------------------------------------
                */

                Route::get('/comments', [ProfileController::class, 'comments'])
                    ->name('comments');

                Route::get('/addresses', [ProfileController::class, 'addresses'])
                    ->name('addresses');

                Route::get('/tickets', [ProfileController::class, 'tickets'])
                    ->name('tickets');

                Route::get('/password', [ProfileController::class, 'password'])
                    ->name('password');

            });

    });

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
