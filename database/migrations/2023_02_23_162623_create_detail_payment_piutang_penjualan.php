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
        Schema::connection('mysql_keuangan')->create('detail_payment_piutang_penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payment_piutang_penjualan_id');
            $table->unsignedBigInteger('piutang_penjualan_id');
            $table->unsignedInteger('tagihan');
            $table->unsignedInteger('terbayar');
            $table->string('status_bayar');
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
        Schema::connection('mysql_keuangan')->dropIfExists('detail_payment_piutang_penjualan');
    }
};
