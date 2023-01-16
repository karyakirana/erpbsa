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
        Schema::create('pembelian_po_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pembelian_po_id');
            $table->unsignedBigInteger('produk_id');
            $table->integer('harga_beli')->nullable();
            $table->integer('jumlah');
            $table->integer('diskon')->nullable();
            $table->integer('sub_total')->nullable();
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
        Schema::dropIfExists('pembelian_po_detail');
    }
};
