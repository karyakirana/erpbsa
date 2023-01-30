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
        Schema::create('stock_keluar', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash', 250);
            $table->unsignedBigInteger('stockable_keluar_id');
            $table->string('stockable_keluar_type');
            $table->string('kode', 20);
            $table->boolean('draft');
            $table->string('kondisi', 20);
            $table->string('status', 20);
            $table->string('surat_jalan', 50)->nullable();
            $table->date('tgl_keluar');
            $table->unsignedBigInteger('lokasi_id');
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('total_barang');
            $table->integer('total_hpp');
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
        Schema::dropIfExists('stock_keluar');
    }
};
