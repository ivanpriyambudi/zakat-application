<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Backoffice\DashboardController;
use App\Http\Controllers\Backoffice\SatuanZakatController;
use App\Http\Controllers\Backoffice\MustahikTypeController;
use App\Http\Controllers\Backoffice\RwRtController;
use App\Http\Controllers\Backoffice\ZakatController;
use App\Http\Controllers\Backoffice\PeopleController;
use App\Http\Controllers\Backoffice\MustahikController;
use App\Http\Controllers\Backoffice\RecaptController;
use App\Http\Controllers\Backoffice\MustahikStatusController;
use App\Http\Middleware\AdminMiddleware;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class, 'showLogin'])->name('showLogin');

Route::group(['prefix' => 'backoffice'], function () {
    Route::impersonate();
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout']);

    Route::group(['middleware' => AdminMiddleware::class], function () {
        Route::resource('zakat', ZakatController::class);
        Route::resource('people', PeopleController::class);
        Route::resource('mustahik', MustahikController::class);
        Route::resource('satuan-zakat', SatuanZakatController::class);
        Route::resource('mustahik-type', MustahikTypeController::class);
        Route::resource('rw-rt', RwRtController::class);
        Route::resource('mustahik-status', MustahikStatusController::class);

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/rw-rt/rt', [RwRtController::class, 'storeRt']);
        Route::put('/satuan-zakat/change-primary/{id}', [SatuanZakatController::class, 'changePrimary']);
        Route::delete('/rw-rt/rt/{id}', [RwRtController::class, 'destroyRt']);
        Route::get('/recapt', [RecaptController::class, 'index']);
        Route::get('/recapt/print', [RecaptController::class, 'printPage']);
        Route::put('/recapt/update-value-distribution', [RecaptController::class, 'updateValueDistribution']);
        Route::post('/recapt/set-amil', [RecaptController::class, 'setAmil']);
        Route::get('/mustahik/delete-tambahan/{id}', [RecaptController::class, 'deleteTambahan']);
        Route::post('/mustahik/update-tambahan/{id}', [RecaptController::class, 'updateTambahan']);
    });
});
