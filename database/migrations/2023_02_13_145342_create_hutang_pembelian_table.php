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
        Schema::connection('mysql_keuangan')->create('hutang_pembelian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saldo_hutang_id'); // supplier Id
            $table->unsignedBigInteger('hutangable_pembelian_id');
            $table->string('hutangable_pembelian_type');
            $table->string('status'); // belum, lunas, sebagian
            $table->date('tgl_hutang');
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
        Schema::connection('mysql_keuangan')->dropIfExists('hutang_pembelian');
    }
};
