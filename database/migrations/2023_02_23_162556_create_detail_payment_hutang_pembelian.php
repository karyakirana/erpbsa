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
        Schema::connection('mysql_keuangan')->create('detail_payment_hutang_pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('payment_hutang_pembelian_id');
            $table->unsignedBigInteger('hutang_pembelian_id');
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
        Schema::connection('mysql_keuangan')->dropIfExists('detail_payment_hutang_pembelian');
    }
};
