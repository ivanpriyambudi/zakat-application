<?php

use App\Events\ZakatRecapt;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BackOffice\DashboardController;
use App\Http\Controllers\BackOffice\SatuanZakatController;
use App\Http\Controllers\BackOffice\MustahikTypeController;
use App\Http\Controllers\BackOffice\RwRtController;
use App\Http\Controllers\BackOffice\ZakatController;
use App\Http\Controllers\BackOffice\PeopleController;
use App\Http\Controllers\BackOffice\MustahikController;
use App\Http\Controllers\BackOffice\RecaptController;
use App\Http\Controllers\BackOffice\MustahikStatusController;
use App\Http\Controllers\BackOffice\YearPeriodController;
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
        Route::resource('year', YearPeriodController::class)->only(['store']);

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/rw-rt/rt', [RwRtController::class, 'storeRt']);
        Route::put('/satuan-zakat/change-primary/{id}', [SatuanZakatController::class, 'changePrimary']);
        Route::delete('/rw-rt/rt/{id}', [RwRtController::class, 'destroyRt']);
        Route::get('/recapt', [RecaptController::class, 'index']);
        Route::get('/recapt/print', [RecaptController::class, 'printPage']);
        Route::put('/recapt/update-value-distribution', [RecaptController::class, 'updateValueDistribution']);
        Route::post('/recapt/set-amil', [RecaptController::class, 'setAmil']);
        Route::post('/recapt/set-doa', [RecaptController::class, 'setDoa']);
        Route::get('/mustahik/delete-tambahan/{id}', [RecaptController::class, 'deleteTambahan']);
        Route::post('/mustahik/update-tambahan/{id}', [RecaptController::class, 'updateTambahan']);
        Route::post('/switch-year', [YearPeriodController::class, 'switchYear']);

        Route::get('/broadcast', function () {
            broadcast(new ZakatRecapt());
        });
    });
});
