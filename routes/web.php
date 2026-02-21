<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => ['web'],
    ],
    function () {
        Route::group(
            [
                'middleware' => ['guest'],
                'prefix' => 'auth',
            ],
            function () {
                Route::get('/login', [LoginController::class, 'index'])->name('login');
                Route::post('/login', [LoginController::class, 'store']);

                Route::get('/register', [RegisterController::class, 'index'])->name('register');
                Route::post('/register', [RegisterController::class, 'store']);
            }
        );

        $isOpenAccess = config('app.open_access');

        Route::group(
            [
                'middleware' => $isOpenAccess ? [] : ['auth'],
            ],
            function () {
                Route::group(
                    [
                        'middleware' => 'auth',
                        'prefix' => 'auth',
                    ],
                    function () {
                        Route::any('/logout', [LoginController::class, 'destroy'])->name('logout');
                    }
                );

                Route::get('/', fn() => inertia('Home'))->name('home');
            }
        );
    });
