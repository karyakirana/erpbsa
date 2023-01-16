<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persediaan', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash', 150);
            $table->unsignedBigInteger('produk_id');
            $table->unsignedBigInteger('lokasi_id');
            $table->string('kondisi', 10);
            $table->string('batch', 20)->nullable();
            $table->date('expired')->nullable();
            $table->integer('harga_beli');
            $table->integer('stock_awal');
            $table->integer('stock_masuk');
            $table->integer('stock_keluar');
            $table->integer('stock_lost');
            $table->integer('stock_saldo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persediaan');
    }
};
