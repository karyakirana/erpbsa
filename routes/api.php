<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('guest')->group(function (){
    // app non auth
    Route::post('login', [\App\Http\Controllers\LoginController::class, 'store'])->name('api.login');
});

Route::middleware('auth:sanctum')->group(function (){
    // app on login
    // jabatan
    Route::get('master/jabatan/{jabatan_id}', [\App\Http\Controllers\Master\JabatanController::class, 'edit']);
    Route::post('master/jabatan/', [\App\Http\Controllers\Master\JabatanController::class, 'store']);
    Route::put('master/jabatan/', [\App\Http\Controllers\Master\JabatanController::class, 'update']);
    Route::patch('master/jabatan', [\App\Http\Controllers\Master\JabatanController::class, 'getData']);
    Route::delete('master/jabatan/', [\App\Http\Controllers\Master\JabatanController::class, 'destroy']);
    // lokasi
    Route::get('master/lokasi/{lokasi_id}', [\App\Http\Controllers\Master\LokasiController::class, 'edit']);
    Route::post('master/lokasi/', [\App\Http\Controllers\Master\LokasiController::class, 'store']);
    Route::put('master/lokasi/', [\App\Http\Controllers\Master\LokasiController::class, 'update']);
    Route::patch('master/lokasi', [\App\Http\Controllers\Master\LokasiController::class, 'getData']);
    Route::delete('master/lokasi/', [\App\Http\Controllers\Master\LokasiController::class, 'destroy']);
    // customer
});
