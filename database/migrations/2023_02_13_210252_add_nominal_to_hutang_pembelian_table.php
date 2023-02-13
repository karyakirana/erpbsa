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
        Schema::connection('mysql_keuangan')->table('hutang_pembelian', function (Blueprint $table) {
            $table->bigInteger('kurang_bayar')->after('tgl_pelunasan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_keuangan')->table('hutang_pembelian', function (Blueprint $table) {
            $table->dropColumn(['kurang_bayar']);
        });
    }
};
