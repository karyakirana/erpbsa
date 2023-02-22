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
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash', 150);
            $table->string('kode', 20);
            $table->unsignedBigInteger('penjualan_penawaran_id')->nullable();
            $table->boolean('draft');
            $table->string('status', 20);
            $table->string('tipe_penjualan'); // tunai or tempo
            $table->date('tgl_penjualan');
            $table->integer('tempo')->nullable();
            $table->date('tgl_tempo')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('sales_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('total_barang');
            $table->integer('ppn')->nullable();
            $table->integer('biaya_lain')->nullable();
            $table->integer('total_bayar');
            $table->text('keterangan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penjualan');
    }
};
