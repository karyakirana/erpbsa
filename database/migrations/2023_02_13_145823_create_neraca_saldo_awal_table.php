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
        Schema::connection('mysql_keuangan')->create('neraca_saldo_awal', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->unsignedBigInteger('akun_id');
            $table->bigInteger('debet')->nullable();
            $table->bigInteger('kredit')->nullable();
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
        Schema::connection('mysql_keuangan')->dropIfExists('neraca_saldo_awal');
    }
};
