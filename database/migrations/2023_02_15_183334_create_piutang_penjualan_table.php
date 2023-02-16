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
        Schema::connection('mysql_keuangan')->create('piutang_penjualan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saldo_piutang_id'); // supplier Id
            $table->unsignedBigInteger('piutangable_penjualan_id');
            $table->string('piutangable_penjualan_type');
            $table->string('status'); // belum, lunas, sebagian
            $table->date('tgl_piutang');
            $table->date('tgl_pelunasan')->nullable();
            $table->text('keterangan')->nullable();
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
        Schema::connection('mysql_keuangan')->dropIfExists('piutang_penjualan');
    }
};
