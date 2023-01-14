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
        Schema::create('customer', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('jenis_instansi', 20);
            $table->string('nama', 50);
            $table->string('telepon', 20);
            $table->string('email', 50)->nullable();
            $table->string('npwp')->nullable();
            $table->text('alamat');
            $table->char('kota_id', 4);
            $table->unsignedBigInteger('sales_id')->nullable();
            $table->smallInteger('diskon');
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
        Schema::dropIfExists('customer');
    }
};
