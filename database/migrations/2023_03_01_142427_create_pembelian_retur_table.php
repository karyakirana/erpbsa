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
        Schema::create('pembelian_retur', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash', 150);
            $table->string('kode', 20);
            $table->unsignedBigInteger('pembelian_id')->nullable();
            $table->string('status', 20);
            $table->date('tgl_retur');
            $table->unsignedBigInteger('supplier_id');
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
        Schema::dropIfExists('pembelian_retur');
    }
};
