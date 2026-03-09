<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\IsAdmin;
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
                Route::get('/', fn() => inertia('Home'))->name('home');

                Route::group(
                    [
                        'middleware' => 'auth',
                    ],
                    function () {
                        Route::any('/auth/logout', [LoginController::class, 'destroy'])->name('logout');

                        Route::group(
                            [
                                'as' => 'post.',
                                'prefix' => 'post'
                            ],
                            function () {
                                Route::get('/create', [PostController::class, 'create'])->name('create');
                            }
                        );
                    }
                );


                Route::group(
                    [
                        'middleware' => IsAdmin::class,
                        'as' => 'admin.',
                        'prefix' => 'admin'
                    ],
                    function () {
                        Route::get('/', fn() => to_route('admin.users.index'))->name('index');

                        Route::group(
                            [
                                'as' => 'users.',
                                'prefix' => 'users'
                            ],
                            function () {
                                Route::get('/', [UserController::class, 'index'])->name('index');
                                Route::post('/{user}/activate', [UserController::class, 'activate'])->name('activate');
                                Route::post('/{user}/deactivate', [UserController::class, 'deactivate'])->name('deactivate');
                                Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
                            }
                        );
                    }
                );
            }
        );
    });
