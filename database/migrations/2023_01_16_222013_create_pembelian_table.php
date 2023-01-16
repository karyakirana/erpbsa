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
        Schema::create('pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash', 150);
            $table->unsignedBigInteger('pembelian_po_id')->nullable();
            $table->string('kode', 20);
            $table->boolean('draft');
            $table->string('status', 20);
            $table->string('tipe_pembelian'); // tunai or tempo
            $table->date('tgl_pembelian');
            $table->integer('tempo')->nullable();
            $table->date('tgl_tempo')->nullable();
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
        Schema::dropIfExists('pembelian');
    }
};
