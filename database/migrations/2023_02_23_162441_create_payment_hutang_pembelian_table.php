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
        Schema::create('payment_hutang_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('akun_payment');
            $table->unsignedBigInteger('total_payment');
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
        Schema::dropIfExists('payment_hutang_pembelian');
    }
};
