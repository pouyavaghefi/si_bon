<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Frontend\LandingController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Http\Controllers\Frontend\ProductCategoryController;
use App\Http\Controllers\Frontend\ProductShowController;
use App\Http\Controllers\Frontend\CartsController;

Route::prefix('/')
    ->name('front.')
    ->group(function () {

        Route::get('/', [LandingController::class, 'index'])
            ->name('landing');

        Route::get('/shop-category', [ProductCategoryController::class, 'category'])
            ->name('shop.categories');

        Route::get('/shop-category/{slug}', [ProductCategoryController::class, 'category'])
            ->name('shop.category');

        Route::get('/product/{slug}', [ProductShowController::class, 'show'])
            ->name('product.show');

        Route::prefix('auth')
            ->name('auth.')
            ->group(function () {

                Route::get('/login', [LoginController::class, 'showLogin'])
                    ->name('login');

                Route::post('/login', [LoginController::class, 'doLogin'])
                    ->name('submit.login');

                Route::get('/register', [RegisterController::class, 'showRegister'])
                    ->name('register');

                Route::post('/register', [RegisterController::class, 'doRegister'])
                    ->name('submit.register');
            });

        Route::middleware('auth')
            ->prefix('user')
            ->name('user.')
            ->group(function () {

                Route::post('/addresses/store', [ProfileController::class, 'storeAddress'])
                    ->name('addresses.store');

                Route::get('/profile', [ProfileController::class, 'showProfile'])
                    ->name('profile');

                Route::put('/profile/update', [ProfileController::class, 'updateProfile'])
                    ->name('profile.update');

                Route::get('/wallet', [ProfileController::class, 'showWallet'])
                    ->name('wallet');

                Route::post('/wallet/deposit', [ProfileController::class, 'depositWallet'])
                    ->name('wallet.deposit');

                Route::get('/orders', [ProfileController::class, 'allOrders'])
                    ->name('orders');

                Route::get('/orders/{order}', [ProfileController::class, 'showOrder'])
                    ->name('orders.show');

                Route::get('/orders/{order}/payment', [ProfileController::class, 'orderPayment'])
                    ->name('orders.payment');

                Route::post('/orders/{order}/continue', [ProfileController::class, 'continueOrder'])
                    ->name('orders.continue');

                Route::get('/orders/new', [ProfileController::class, 'newOrders'])
                    ->name('orders.new');

                Route::get('/orders/ready', [ProfileController::class, 'readyOrders'])
                    ->name('orders.ready');

                Route::get('/orders/completed', [ProfileController::class, 'completedOrders'])
                    ->name('orders.completed');

                Route::get('/finance', [ProfileController::class, 'finance'])
                    ->name('finance');

                Route::get('/deposits', [ProfileController::class, 'deposits'])
                    ->name('deposits');

                Route::get('/credits', [ProfileController::class, 'credits'])
                    ->name('credits');

                Route::get('/cashback', [ProfileController::class, 'cashback'])
                    ->name('cashback');

                Route::get('/comments', [ProfileController::class, 'comments'])
                    ->name('comments');

                Route::get('/addresses', [ProfileController::class, 'addresses'])
                    ->name('addresses');

                Route::get('/tickets', [ProfileController::class, 'tickets'])
                    ->name('tickets');

                Route::get('/password', [ProfileController::class, 'password'])
                    ->name('password');
            });

        Route::prefix('cart')
            ->name('cart.')
            ->group(function () {

                Route::get('/', [CartsController::class, 'index'])
                    ->name('index');

                Route::post('/add-taki', [CartsController::class, 'addTaki'])
                    ->name('addTaki');

                Route::post('/add-print', [CartsController::class, 'addPrint'])
                    ->name('addPrint');

                Route::get('/edit/{key}', [CartsController::class, 'edit'])
                    ->name('edit');

                Route::put('/update/{key}', [CartsController::class, 'update'])
                    ->name('update');

                Route::delete('/remove/{key}', [CartsController::class, 'remove'])
                    ->name('remove');

                Route::delete('/clear', [CartsController::class, 'clear'])
                    ->name('clear');
            });

        Route::get('/checkout', [CartsController::class, 'checkoutPage'])
            ->name('checkout.index');

        Route::post('/checkout', [CartsController::class, 'checkout'])
            ->name('cart.checkout');

        Route::get('/checkout/success/{order}', [CartsController::class, 'success'])
            ->name('cart.success');
    });

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
