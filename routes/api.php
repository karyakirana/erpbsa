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

Route::middleware('auth:sanctum')->get('sessiontest', function (){
    return response()->json([
        'session' => session('ClosedCash')
    ], 200);
});

Route::middleware('auth:sanctum')->group(function (){
    // app on login
    // jabatan
    Route::get('master/jabatan/{jabatan_id}', [\App\Http\Controllers\Master\JabatanController::class, 'edit']);
    Route::post('master/jabatan/', [\App\Http\Controllers\Master\JabatanController::class, 'store']);
    Route::put('master/jabatan/', [\App\Http\Controllers\Master\JabatanController::class, 'update']);
    Route::patch('master/jabatan', [\App\Http\Controllers\Master\JabatanController::class, 'getData']);
    Route::delete('master/jabatan/{id}', [\App\Http\Controllers\Master\JabatanController::class, 'destroy']);
    // pegawai
    Route::get('master/pegawai/{pegawai_id}', [\App\Http\Controllers\Master\PegawaiController::class, 'edit']);
    Route::post('master/pegawai/', [\App\Http\Controllers\Master\PegawaiController::class, 'store']);
    Route::put('master/pegawai/', [\App\Http\Controllers\Master\PegawaiController::class, 'update']);
    Route::patch('master/pegawai', [\App\Http\Controllers\Master\PegawaiController::class, 'view']);
    Route::delete('master/pegawai/{id}', [\App\Http\Controllers\Master\PegawaiController::class, 'destroy']);
    // lokasi
    Route::get('master/lokasi/{lokasi_id}', [\App\Http\Controllers\Master\LokasiController::class, 'edit']);
    Route::post('master/lokasi/', [\App\Http\Controllers\Master\LokasiController::class, 'store']);
    Route::put('master/lokasi/', [\App\Http\Controllers\Master\LokasiController::class, 'update']);
    Route::patch('master/lokasi', [\App\Http\Controllers\Master\LokasiController::class, 'getData']);
    Route::delete('master/lokasi/{id}', [\App\Http\Controllers\Master\LokasiController::class, 'destroy']);
    // supplier
    Route::get('master/supplier/{supplier_id}', [\App\Http\Controllers\Master\SupplierController::class, 'edit']);
    Route::post('master/supplier/', [\App\Http\Controllers\Master\SupplierController::class, 'store']);
    Route::put('master/supplier/', [\App\Http\Controllers\Master\SupplierController::class, 'update']);
    Route::patch('master/supplier', [\App\Http\Controllers\Master\SupplierController::class, 'view']);
    Route::delete('master/supplier/{id}', [\App\Http\Controllers\Master\SupplierController::class, 'destroy']);
    // customer
    Route::get('master/customer/{customer_id}', [\App\Http\Controllers\Master\CustomerController::class, 'edit']);
    Route::post('master/customer/', [\App\Http\Controllers\Master\CustomerController::class, 'store']);
    Route::put('master/customer/', [\App\Http\Controllers\Master\CustomerController::class, 'update']);
    Route::patch('master/customer', [\App\Http\Controllers\Master\CustomerController::class, 'view']);
    Route::delete('master/customer/{id}', [\App\Http\Controllers\Master\CustomerController::class, 'destroy']);
    // produk kategori
    Route::get('master/produkkategori/{produk_kategori_id}', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'edit']);
    Route::post('master/produkkategori/', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'store']);
    Route::put('master/produkkategori/', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'update']);
    Route::patch('master/produkkategori', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'view']);
    Route::delete('master/produkkategori/{id}', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'destroy']);
    // produk
    Route::get('master/produk/{produk_id}', [\App\Http\Controllers\Master\ProdukController::class, 'edit']);
    Route::post('master/produk/', [\App\Http\Controllers\Master\ProdukController::class, 'store']);
    Route::put('master/produk/', [\App\Http\Controllers\Master\ProdukController::class, 'update']);
    Route::patch('master/produk', [\App\Http\Controllers\Master\ProdukController::class, 'view']);
    Route::delete('master/produk/{id}', [\App\Http\Controllers\Master\ProdukController::class, 'destroy']);
    // kota indonesia
    Route::get('master/kota/{id}', [\App\Http\Controllers\Master\WilayahIndonesiaController::class, 'kotaIndonesia']);
    Route::patch('master/kota/', [\App\Http\Controllers\Master\WilayahIndonesiaController::class, 'kotaIndonesia']);
});

Route::middleware('auth:sanctum')->group(function (){
    // persediaan
    Route::get('persediaan', [\App\Http\Controllers\Stock\PersediaanController::class, 'getData']);
    // persediaan awal
    Route::get('persediaan/awal/{persediaan_awal_id}', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'edit']);
    Route::post('persediaan/awal/', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'store']);
    Route::put('persediaan/awal/', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'update']);
    Route::patch('persediaan/awal', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'show']);
    Route::delete('persediaan/awal/{id}', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function (){
    // pembelian purchaseorder
    Route::get('pembelian/purchaseorder/{pemmbelian_po_id}', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'edit']);
    Route::post('pembelian/purchaseorder/', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'store']);
    Route::put('pembelian/purchaseorder/', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'update']);
    Route::patch('pembelian/purchaseorder', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'show']);
    Route::delete('pembelian/purchaseorder/{id}', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'destroy']);
    // pembelian
    Route::get('pembelian/{pemmbelian_id}', [\App\Http\Controllers\Pembelian\PembelianController::class, 'edit']);
    Route::post('pembelian/', [\App\Http\Controllers\Pembelian\PembelianController::class, 'store']);
    Route::put('pembelian/', [\App\Http\Controllers\Pembelian\PembelianController::class, 'update']);
    Route::patch('pembelian/', [\App\Http\Controllers\Pembelian\PembelianController::class, 'show']);
    Route::delete('pembelian/{id}', [\App\Http\Controllers\Pembelian\PembelianController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function (){
    // penjualan
    Route::get('penjualan/{penjualan_id}', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'edit']);
    Route::post('penjualan/', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'store']);
    Route::put('penjualan/', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'update']);
    Route::patch('penjualan/', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'show']);
    Route::delete('penjualan/{penjualan_id}', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'destroy']);
});
