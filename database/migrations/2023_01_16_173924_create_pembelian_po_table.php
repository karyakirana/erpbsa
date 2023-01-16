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
        Schema::create('pembelian_po', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash', 150);
            $table->string('kode', 20);
            $table->boolean('draft')->default(false);
            $table->string('status', 20);
            $table->date('tgl_pembelian_po');
            $table->integer('durasi_po')->nullable();
            $table->date('tgl_kadaluarsa_po')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('total_barang');
            $table->integer('ppn')->nullable();
            $table->integer('biaya_lain')->nullable();
            $table->integer('total_bayar');
            $table->text('keterangan')->nullable();
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
        Schema::dropIfExists('pembelian_po');
    }
};
