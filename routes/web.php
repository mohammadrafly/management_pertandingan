<?php

use App\Http\Controllers\Authentication\AuthController;
use App\Http\Controllers\Dashboard\AtletController;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\KelasController;
use App\Http\Controllers\Dashboard\PembayaranController;
use App\Http\Controllers\Dashboard\PertandinganController;
use App\Http\Controllers\Dashboard\TimController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Manajer\AtletController as ManajerAtletController;
use App\Http\Controllers\Manajer\KelasController as ManajerKelasController;
use App\Http\Controllers\Manajer\PembayaranController as ManajerPembayaranController;
use App\Http\Controllers\Manajer\PertandinganController as ManajerPertandinganController;
use App\Http\Controllers\Manajer\TimController as ManajerTimController;
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
                    Route::get('list/atlet/{id}', 'listAtlet')->name('kelas.list.atlet');
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
            Route::prefix('pertandingan')->group(function() {
                Route::controller(PertandinganController::class)->group(function() {
                    Route::match(['GET'], '/', 'index')->name('pertandingan');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('pertandingan.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('pertandingan.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('pertandingan.delete');
                });
            });
            Route::prefix('tim')->group(function() {
                Route::controller(TimController::class)->group(function() {
                    Route::match(['GET'], '/', 'index')->name('tim');
                    Route::match(['GET', 'POST'], 'create', 'create')->name('tim.create');
                    Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('tim.update');
                    Route::match(['GET'], 'delete/{id}', 'delete')->name('tim.delete');
                });
            });
        });
        Route::middleware('authenticatedAs:manager')->group(function() {
            Route::prefix('manajer')->group(function() {
                Route::prefix('my/atlet')->group(function() {
                    Route::controller(ManajerAtletController::class)->group(function() {
                        Route::match(['GET'], '/', 'index')->name('manajer.atlet');
                        Route::match(['GET', 'POST'], 'create', 'create')->name('manajer.atlet.create');
                        Route::match(['GET', 'POST'], 'update/{id}', 'update')->name('manajer.atlet.update');
                        Route::match(['GET'], 'delete/{id}', 'delete')->name('manajer.atlet.delete');
                        Route::get('idcard/{id}', 'cetakIdCard')->name('manajer.atlet.cetak-idcard');
                        Route::get('list/idcard', 'idCard')->name('manajer.atlet.list.idcard');
                    });
                });
                Route::prefix('my/tim')->group(function() {
                    Route::controller(ManajerTimController::class)->group(function() {
                        Route::match(['GET', 'POST'], '/', 'index')->name('manajer.my.tim');
                    });
                });
                Route::prefix('my/pembayaran')->group(function() {
                    Route::controller(ManajerPembayaranController::class)->group(function() {
                        Route::match(['GET'], '{team}', 'index')->name('manajer.pembayaran');
                    });
                });
                Route::prefix('pertandingan')->group(function() {
                    Route::controller(ManajerPertandinganController::class)->group(function() {
                        Route::match(['GET', 'POST'], '/', 'index')->name('manajer.pertandingan');
                        Route::match(['GET'], 'daftar/{pertandingan}/{team}', 'daftarPertandingan')->name('manajer.pertandingan.daftar');
                        Route::get('bayar/{pertandingan}/{team}', 'bayarDanAktivasi')->name('manajer.pertandingan.bayar');
                    });
                });
                Route::prefix('kelas')->group(function() {
                    Route::controller(ManajerKelasController::class)->group(function() {
                        Route::match(['GET'], '/', 'index')->name('manajer.kelas');
                        Route::prefix('list')->group(function() {
                            Route::match(['GET'], '/{kelas}', 'list')->name('manajer.kelas.list');
                            Route::match(['GET', 'POST'], 'create/{kelas}', 'create')->name('manajer.kelas.create');
                            Route::match(['GET', 'POST'], 'update/{kelas}/{id}', 'update')->name('manajer.kelas.update');
                            Route::match(['GET'], 'delete/{kelas}/{id}', 'delete')->name('manajer.kelas.delete');
                        });
                    });
                });
            });
        });
    });
});

Route::controller(ManajerPertandinganController::class)->group(function() {
    Route::post('api/callback/success/{id}', 'callbackSuccess')->name('api.callback.success');
});
