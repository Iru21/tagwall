<?php

use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TagSearchController;
use App\Http\Controllers\UserSettingsController;
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
                Route::get('/', [HomeController::class, 'index'])->name('home');
                Route::get('/search', [SearchController::class, 'index'])->name('search');
                Route::get('/settings', [UserSettingsController::class, 'index'])->name('settings.index');

                Route::group(
                    [
                        'middleware' => 'auth',
                    ],
                    function () {
                        Route::put('/settings', [UserSettingsController::class, 'update'])->name('settings.update');

                        Route::any('/auth/logout', [LoginController::class, 'destroy'])->name('logout');

                        Route::group(
                            [
                                'as' => 'posts.',
                                'prefix' => 'posts'
                            ],
                            function () {
                                Route::get('/', [PostController::class, 'create'])->name('create');
                                Route::post('/', [PostController::class, 'store'])->name('store');
                            }
                        );
                    }
                );

                Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
                Route::get('/tags', [TagSearchController::class, 'index'])->name('tags.index');

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

                        Route::group(
                            [
                                'as' => 'tags.',
                                'prefix' => 'tags'
                            ],
                            function () {
                                Route::get('/', [TagController::class, 'index'])->name('index');
                                Route::delete('/{tag}', [TagController::class, 'destroy'])->name('destroy');
                            }
                        );
                    }
                );
            }
        );
    });
