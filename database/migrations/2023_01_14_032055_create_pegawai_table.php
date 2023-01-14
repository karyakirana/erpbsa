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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('status', 20);
            $table->string('nama', 50);
            $table->string('gender', 10);
            $table->string('telepon', 20);
            $table->string('email', 50);
            $table->string('npwp', 20)->nullable();
            $table->unsignedBigInteger('jabatan_id');
            $table->text('alamat');
            $table->char('kota_id', 4);
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
        Schema::dropIfExists('pegawai');
    }
};
