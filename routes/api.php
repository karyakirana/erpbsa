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
    Route::get('master/jabatan', [\App\Http\Controllers\Master\JabatanController::class, 'getData']);
    Route::delete('master/jabatan/{id}', [\App\Http\Controllers\Master\JabatanController::class, 'destroy']);
    // pegawai
    Route::get('master/pegawai/{pegawai_id}', [\App\Http\Controllers\Master\PegawaiController::class, 'edit']);
    Route::post('master/pegawai/', [\App\Http\Controllers\Master\PegawaiController::class, 'store']);
    Route::put('master/pegawai/', [\App\Http\Controllers\Master\PegawaiController::class, 'update']);
    Route::get('master/pegawai', [\App\Http\Controllers\Master\PegawaiController::class, 'view']);
    Route::patch('master/pegawai', [\App\Http\Controllers\Master\PegawaiController::class, 'view']);
    Route::delete('master/pegawai/{id}', [\App\Http\Controllers\Master\PegawaiController::class, 'destroy']);
    // lokasi
    Route::get('master/lokasi/{lokasi_id}', [\App\Http\Controllers\Master\LokasiController::class, 'edit']);
    Route::post('master/lokasi/', [\App\Http\Controllers\Master\LokasiController::class, 'store']);
    Route::put('master/lokasi/', [\App\Http\Controllers\Master\LokasiController::class, 'update']);
    Route::get('master/lokasi', [\App\Http\Controllers\Master\LokasiController::class, 'getData']);
    Route::delete('master/lokasi/{id}', [\App\Http\Controllers\Master\LokasiController::class, 'destroy']);
    // supplier
    Route::get('master/supplier/{supplier_id}', [\App\Http\Controllers\Master\SupplierController::class, 'edit']);
    Route::post('master/supplier/', [\App\Http\Controllers\Master\SupplierController::class, 'store']);
    Route::put('master/supplier/', [\App\Http\Controllers\Master\SupplierController::class, 'update']);
    Route::get('master/supplier', [\App\Http\Controllers\Master\SupplierController::class, 'view']);
    Route::delete('master/supplier/{id}', [\App\Http\Controllers\Master\SupplierController::class, 'destroy']);
    // customer
    Route::get('master/customer/{customer_id}', [\App\Http\Controllers\Master\CustomerController::class, 'edit']);
    Route::post('master/customer/', [\App\Http\Controllers\Master\CustomerController::class, 'store']);
    Route::put('master/customer/', [\App\Http\Controllers\Master\CustomerController::class, 'update']);
    Route::get('master/customer', [\App\Http\Controllers\Master\CustomerController::class, 'view']);
    Route::delete('master/customer/{id}', [\App\Http\Controllers\Master\CustomerController::class, 'destroy']);
    // produk kategori
    Route::get('master/produkkategori/{produk_kategori_id}', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'edit']);
    Route::post('master/produkkategori/', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'store']);
    Route::put('master/produkkategori/', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'update']);
    Route::get('master/produkkategori', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'view']);
    Route::delete('master/produkkategori/{id}', [\App\Http\Controllers\Master\ProdukKategoriController::class, 'destroy']);
    // produk
    Route::get('master/produk/{produk_id}', [\App\Http\Controllers\Master\ProdukController::class, 'edit']);
    Route::post('master/produk/', [\App\Http\Controllers\Master\ProdukController::class, 'store']);
    Route::put('master/produk/', [\App\Http\Controllers\Master\ProdukController::class, 'update']);
    Route::get('master/produk', [\App\Http\Controllers\Master\ProdukController::class, 'view']);
    Route::delete('master/produk/{id}', [\App\Http\Controllers\Master\ProdukController::class, 'destroy']);
    // kota indonesia
    Route::get('master/kota/{id}', [\App\Http\Controllers\Master\WilayahIndonesiaController::class, 'kotaIndonesia']);
    Route::get('master/kota/', [\App\Http\Controllers\Master\WilayahIndonesiaController::class, 'kotaIndonesia']);
});

Route::middleware('auth:sanctum')->group(function (){
    // persediaan
    Route::get('persediaan', [\App\Http\Controllers\Stock\PersediaanController::class, 'getData']);
    Route::get('persediaan/{id}/edit', [\App\Http\Controllers\Stock\PersediaanController::class, 'edit']);
    // persediaan awal
    Route::get('persediaan/awal/{persediaan_awal_id}', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'edit']);
    Route::post('persediaan/awal/', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'store']);
    Route::put('persediaan/awal/', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'update']);
    Route::get('persediaan/awal', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'show']);
    Route::delete('persediaan/awal/{id}', [\App\Http\Controllers\Stock\PersediaanAwalController::class, 'destroy']);

    // stock masuk
    Route::get('persediaan/masuk/pembelian/{id}', [\App\Http\Controllers\Stock\StockMasukPembelianController::class, 'edit']);
    Route::get('persediaan/masuk/pembelian', [\App\Http\Controllers\Stock\StockMasukPembelianController::class, 'show']);
    Route::post('persediaan/masuk/pembelian', [\App\Http\Controllers\Stock\StockMasukPembelianController::class, 'store']);

    // stock masuk
    Route::get('stock/masuk', [\App\Http\Controllers\Stock\StockMasukController::class, 'index']);
    Route::get('stock/masuk/{id}/edit', [\App\Http\Controllers\Stock\StockMasukController::class, 'edit']);
    Route::post('stock/masuk', [\App\Http\Controllers\Stock\StockMasukController::class, 'store']);
    Route::put('stock/masuk', [\App\Http\Controllers\Stock\StockMasukController::class, 'update']);
    Route::delete('stock/masuk/{id}/delete', [\App\Http\Controllers\Stock\StockMasukController::class, 'delete']);

    // stock keluar
    Route::get('persediaan/keluar/penjualan/{id}', [\App\Http\Controllers\Stock\StockKeluarPenjualanController::class, 'edit']);
    Route::get('persediaan/keluar/penjualan', [\App\Http\Controllers\Stock\StockKeluarPenjualanController::class, 'index']);
    Route::post('persediaan/keluar/penjualan', [\App\Http\Controllers\Stock\StockKeluarPenjualanController::class, 'store']);
    Route::put('persediaan/keluar/penjualan', [\App\Http\Controllers\Stock\StockKeluarPenjualanController::class, 'update']);
    Route::delete('persediaan/keluar/penjualan/{id}', [\App\Http\Controllers\Stock\StockKeluarPenjualanController::class, 'destroy']);

    // stock keluar
    Route::get('stock/keluar', [\App\Http\Controllers\Stock\StockKeluarController::class, 'index']);
    Route::get('stock/keluar/{id}/edit', [\App\Http\Controllers\Stock\StockKeluarController::class, 'edit']);
    Route::post('stock/keluar', [\App\Http\Controllers\Stock\StockKeluarController::class, 'store']);
    Route::put('stock/keluar', [\App\Http\Controllers\Stock\StockKeluarController::class, 'update']);
    Route::delete('stock/keluar/{id}/delete', [\App\Http\Controllers\Stock\StockKeluarController::class, 'delete']);
});

Route::middleware('auth:sanctum')->group(function (){
    // pembelian purchaseorder
    Route::get('pembelian/purchaseorder/{pemmbelian_po_id}', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'edit']);
    Route::post('pembelian/purchaseorder/', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'store']);
    Route::put('pembelian/purchaseorder/', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'update']);
    Route::get('pembelian/purchaseorder', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'show']);
    Route::delete('pembelian/purchaseorder/{id}', [\App\Http\Controllers\Pembelian\PembelianPOController::class, 'destroy']);
    // pembelian
    Route::get('pembelian/{pemmbelian_id}', [\App\Http\Controllers\Pembelian\PembelianController::class, 'edit']);
    Route::post('pembelian/', [\App\Http\Controllers\Pembelian\PembelianController::class, 'store']);
    Route::put('pembelian/', [\App\Http\Controllers\Pembelian\PembelianController::class, 'update']);
    Route::get('pembelian/', [\App\Http\Controllers\Pembelian\PembelianController::class, 'show']);
    Route::delete('pembelian/{id}', [\App\Http\Controllers\Pembelian\PembelianController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function (){
    // penjualan
    Route::get('penjualan', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'show']);
    Route::get('penjualan/{penjualan_id}', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'edit']);
    Route::post('penjualan/', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'store']);
    Route::put('penjualan/', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'update']);
    Route::patch('penjualan/', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'show']);
    Route::delete('penjualan/{penjualan_id}', [\App\Http\Controllers\Penjualan\PenjualanController::class, 'destroy']);

    // penjualan KSO
});

// keuangan
Route::middleware('auth:sanctum')->group(function (){
    // akuntansi route

    // master akun route
    Route::get('akun', [\App\Http\Controllers\Akuntansi\AkunController::class, 'index']);
    Route::get('akun/{akun_id}/edit', [\App\Http\Controllers\Akuntansi\AkunController::class, 'edit']);
    Route::post('akun', [\App\Http\Controllers\Akuntansi\AkunController::class, 'store']);
    Route::put('akun', [\App\Http\Controllers\Akuntansi\AkunController::class, 'update']);
    Route::delete('akun/{akun_id}/destroy', [\App\Http\Controllers\Akuntansi\AkunController::class, 'edit']);
    // master akun kategori
    Route::get('akun/kategori', [\App\Http\Controllers\Akuntansi\AkunKategoriController::class, 'index']);
    Route::get('akun/kategori/{akun_kategori_id}/edit', [\App\Http\Controllers\Akuntansi\AkunKategoriController::class, 'edit']);
    Route::post('akun/kategori', [\App\Http\Controllers\Akuntansi\AkunKategoriController::class, 'store']);
    Route::put('akun/kategori', [\App\Http\Controllers\Akuntansi\AkunKategoriController::class, 'update']);
    Route::delete('akun/kategori/{akun_kategori_id}/edit', [\App\Http\Controllers\Akuntansi\AkunKategoriController::class, 'destroy']);
    // master akun tipe
    Route::get('akun/tipe', [\App\Http\Controllers\Akuntansi\AkunTipeController::class, 'index']);
    Route::get('akun/tipe/{akun_tipe_id}/edit', [\App\Http\Controllers\Akuntansi\AkunTipeController::class, 'edit']);
    Route::post('akun/tipe', [\App\Http\Controllers\Akuntansi\AkunTipeController::class, 'store']);
    Route::put('akun/tipe', [\App\Http\Controllers\Akuntansi\AkunTipeController::class, 'update']);
    Route::delete('akun/tipe/{akun_tipe_id}/edit', [\App\Http\Controllers\Akuntansi\AkunTipeController::class, 'destroy']);

    // coa config
    Route::get('config/coa/', [\App\Http\Controllers\Akuntansi\CoaConfigController::class, 'index']);
    Route::get('config/coa/edit/{config}', [\App\Http\Controllers\Akuntansi\CoaConfigController::class, 'edit']);
    Route::put('config/coa', [\App\Http\Controllers\Akuntansi\CoaConfigController::class, 'update']);

    // ppn config

    // route hutang pembelian
    Route::get('hutang/pembelian', [\App\Http\Controllers\Pembelian\HutangPembelianController::class, 'index']);
    Route::get('hutang/pembelian/view/{hutang_pembelian_id}', [\App\Http\Controllers\Pembelian\HutangPembelianController::class, 'edit']);

    // route piutang penjualan
    Route::get('piutang/penjualan', [\App\Http\Controllers\Penjualan\PiutangPenjualanController::class, 'index']);
    Route::get('piutang/penjualan/view/{piutang_penjualan_id}', [\App\Http\Controllers\Penjualan\PiutangPenjualanController::class, 'edit']);

    // payment

    // payment pembelian
    Route::get('payment/penjualan');
    Route::get('payment/penjualan/{payment_penjualan_id}');
    Route::post('payment/penjualan');
    Route::put('payment/penjualan');
    Route::delete('payment/penjualan');

    // payment penjualan
    Route::get('payment/pembelian');
    Route::get('payment/pembelian/{payment_pembelian_id}');
    Route::post('payment/pembelian');
    Route::put('payment/pembelian');

});
