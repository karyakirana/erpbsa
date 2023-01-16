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
        Schema::create('persediaan_awal', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash', 150);
            $table->string('kode', 20);
            $table->boolean('draft')->default(false);
            $table->string('kondisi', 10);
            $table->unsignedBigInteger('lokasi_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('total_barang');
            $table->integer('total_nominal');
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
        Schema::dropIfExists('persediaan_awal');
    }
};
