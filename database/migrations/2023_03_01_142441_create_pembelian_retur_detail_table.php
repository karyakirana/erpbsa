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
        Schema::create('pembelian_retur_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelian_retur_id');
            $table->unsignedBigInteger('persediaan_id');
            $table->integer('harga_jual');
            $table->integer('jumlah');
            $table->string('satuan_jual', 20);
            $table->integer('diskon');
            $table->integer('sub_total');
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
        Schema::dropIfExists('pembelian_retur_detail');
    }
};
