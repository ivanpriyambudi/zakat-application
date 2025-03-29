<?php

use App\Http\Controllers\Api\YearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KodeGeneratorController;
use App\Http\Controllers\Api\ZakatApiController;
use App\Http\Controllers\Api\MustahikApiController;
use App\Http\Controllers\Api\MustahiStatusApiController;
use App\Http\Controllers\Api\PeopleApiController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'backoffice'], function () {
    Route::get('/kode-generator', [KodeGeneratorController::class, 'makeCode']);
    Route::get('/count-zakat-year', [ZakatApiController::class, 'getAmountZakat']);
    Route::get('/count-mustahik-year', [MustahikApiController::class, 'getCountMustahik']);
    Route::get('/zakat-rt', [ZakatApiController::class, 'getZakatRt']);
    Route::get('/zakat-rt/recapt', [ZakatApiController::class, 'getZakatRtWithPenerima']);
    Route::get('/recent-zakat', [ZakatApiController::class, 'getRecentZakat']);
    Route::get('/mustahik-status/pembagian', [MustahiStatusApiController::class, 'getData']);
    Route::get('/mustahik/search', [MustahikApiController::class, 'getMustahikTambahan']);
    Route::post('/mustahik/update-distribution/{id}', [MustahikApiController::class, 'onAddDistribution']);
    Route::get('/zakat-tambahan/recapt', [ZakatApiController::class, 'getZakatPenerimaTambahan']);
    Route::get('/zakat-tambahan-rt/recapt', [ZakatApiController::class, 'getTambahanZakatRt']);
    Route::get('/mustahik/recapt', [ZakatApiController::class, 'getSummaryPenerima']);
    Route::post('/people/search', [PeopleApiController::class, 'getSearch']);
    Route::get('/zakat-tambahan/summary', [ZakatApiController::class, 'getSummaryZakatPenerimaTambahan']);
    Route::get('/years', [YearController::class, 'getData']);
});
