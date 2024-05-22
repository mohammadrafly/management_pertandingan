<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Dashboard\AtletController;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\KategoriController;
use App\Http\Controllers\Dashboard\KelasController;
use App\Http\Controllers\Dashboard\List\ListTimController;
use App\Http\Controllers\Dashboard\List\ListTimPertandinganController;
use App\Http\Controllers\Dashboard\PembayaranController;
use App\Http\Controllers\Dashboard\PertandinganController;
use App\Http\Controllers\Dashboard\TimController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::match(['GET', 'POST'], '/', 'index')->name('login');
        Route::match(['GET', 'POST'], 'register', 'register')->name('register');
    });
});

Route::middleware('auth')->group(function() {
    Route::prefix('dashboard')->group(function() {
        Route::controller(IndexController::class)->group(function() {
            Route::match(['GET'], '/', 'index')->name('dashboard');
            Route::match(['GET'], 'logout', 'logout')->name('logout');
            Route::match(['GET', 'POST'], 'profile', 'profile')->name('profile');
            Route::match(['GET', 'POST'], 'password', 'password')->name('password');
        });
        Route::middleware('authenticatedAs:admin')->group(function() {
            Route::prefix('user')->group(function() {
                Route::controller(UserController::class)->group(function() {
                    Route::match(['GET'], '/', 'index')->name('user');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('user.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('user.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('user.delete');
                });
            });
            Route::prefix('atlet')->group(function() {
                Route::controller(AtletController::class)->group(function() {
                    Route::match(['GET'], '/', 'index')->name('atlet');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('atlet.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('atlet.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('atlet.delete');
                });
            });
            Route::prefix('kelas')->group(function() {
                Route::controller(KelasController::class)->group(function() {
                    Route::match(['GET'], '/', 'index')->name('kelas');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('kelas.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('kelas.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('kelas.delete');
                });
            });
            Route::prefix('pembayaran')->group(function() {
                Route::controller(PembayaranController::class)->group(function() {
                    Route::match(['GET'], '/', 'index')->name('pembayaran');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('pembayaran.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('pembayaran.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('pembayaran.delete');
                });
            });
            Route::prefix('setting')->group(function() {
                Route::controller(SettingController::class)->group(function() {
                    Route::match(['GET'], '/', 'index')->name('setting');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('setting.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('setting.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('setting.delete');
                });
            });
        });
        Route::prefix('pertandingan')->group(function() {
            Route::controller(PertandinganController::class)->group(function() {
                Route::match(['GET'], '/', 'index')->name('pertandingan');
                Route::match(['GET', 'POST'], 'create', 'create')->name('pertandingan.create');
                Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('pertandingan.update');
                Route::match(['GET'], 'delete/{id}', 'delete')->name('pertandingan.delete');
            });
            Route::prefix('list/tim')->group(function() {
                Route::controller(ListTimPertandinganController::class)->group(function() {
                    Route::match(['GET'], '{id}', 'index')->name('pertandingan.list');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('pertandingan.list.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('pertandingan.list.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('pertandingan.list.delete');
                });
            });
        });
        Route::prefix('tim')->group(function() {
            Route::controller(TimController::class)->group(function() {
                Route::match(['GET'], '/', 'index')->name('tim');
                Route::match(['GET', 'POST'], 'create', 'create')->name('tim.create');
                Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('tim.update');
                Route::match(['GET'], 'delete/{id}', 'delete')->name('tim.delete');
            });
            Route::prefix('list/atlet')->group(function() {
                Route::controller(ListTimController::class)->group(function() {
                    Route::match(['GET'], '{id}', 'index')->name('tim.list');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('tim.list.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('tim.list.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('tim.list.delete');
                });
            });
        });
    });
});