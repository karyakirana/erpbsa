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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_kategori_id');
            $table->string('kode', 20);
            $table->string('status', 20);
            $table->string('nama', 100);
            $table->text('tipe')->nullable();
            $table->string('merk', 50);
            $table->string('satuan_jual', 20);
            $table->integer('harga');
            $table->smallInteger('max_diskon');
            $table->integer('buffer_stock');
            $table->integer('minimum_stock');
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
        Schema::dropIfExists('produk');
    }
};
