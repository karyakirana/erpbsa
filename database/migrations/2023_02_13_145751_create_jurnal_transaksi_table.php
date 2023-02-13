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
        Schema::connection('mysql_keuangan')->create('jurnal_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('active_cash');
            $table->unsignedBigInteger('jurnalable_transaksi_id');
            $table->string('jurnalable_transaksi_type');
            $table->unsignedBigInteger('akun_id');
            $table->bigInteger('debet')->default(0);
            $table->bigInteger('kredit')->default(0);
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
        Schema::connection('mysql_keuangan')->dropIfExists('jurnal_transaksi');
    }
};
