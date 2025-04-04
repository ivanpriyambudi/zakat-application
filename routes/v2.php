<?php

use App\Http\Controllers\V2\RtController;
use App\Http\Controllers\V2\RwContrroller;
use App\Http\Controllers\V2\SatuanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V2\Auth\Login;
use App\Http\Controllers\V2\Auth\Logout;
use App\Http\Controllers\V2\Auth\Me;
use App\Http\Controllers\V2\DistributionSettingController;
use App\Http\Controllers\V2\DistributionSettingItemController;
use App\Http\Controllers\V2\MustahikController;
use App\Http\Controllers\V2\MustahikTypeController;
use App\Http\Controllers\V2\MustahikYearPeriodController;
use App\Http\Controllers\V2\PeopleController;
use App\Http\Controllers\V2\RecaptController;
use App\Http\Controllers\V2\YearPeriodController;
use App\Http\Controllers\V2\ZakatController;

Route::prefix('auth')->group(function () {
    Route::post('/login', Login::class);
    Route::post('/logout', Logout::class);
    Route::get('/me', Me::class);
});

Route::middleware(['auth:api'])->group(function () {
    Route::resource('satuan-zakat', SatuanController::class);
    Route::resource('rw', RwContrroller::class);
    Route::resource('rt', RtController::class);
    Route::resource('mustahik-type', MustahikTypeController::class);
    Route::resource('mustahik', MustahikController::class);
    Route::resource('people', PeopleController::class);
    Route::resource('zakat', ZakatController::class);
    Route::resource('year-period', YearPeriodController::class);
    Route::resource('mustahik-year-period', MustahikYearPeriodController::class);
    Route::resource('distribution-setting', DistributionSettingController::class);
    Route::resource('distribution-setting-item', DistributionSettingItemController::class);

    Route::get('/recapt/dashboard', [RecaptController::class, 'dashboard']);
    Route::post('/recapt/setting/mustahik', [RecaptController::class, 'storeMustahik']);
    Route::get('/recapt/per-rt', [RecaptController::class, 'recaptPerRt']);
    Route::get('/recapt/per-rt-penerima', [RecaptController::class, 'recaptPerRtPenerima']);
});
