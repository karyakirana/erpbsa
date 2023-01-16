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
        Schema::create('persediaan_awal_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persediaan_awal_id');
            $table->unsignedBigInteger('persediaan_id');
            $table->integer('harga_beli');
            $table->integer('jumlah');
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
        Schema::dropIfExists('persediaan_awal_detail');
    }
};
