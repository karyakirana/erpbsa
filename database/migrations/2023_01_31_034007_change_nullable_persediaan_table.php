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
        Schema::table('persediaan', function (Blueprint $table) {
            $table->integer('stock_awal')->nullable()->default(0)->change();
            $table->integer('stock_masuk')->nullable()->default(0)->change();
            $table->integer('stock_keluar')->nullable()->default(0)->change();
            $table->integer('stock_lost')->nullable()->default(0)->change();
            $table->integer('stock_saldo')->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persediaan', function (Blueprint $table) {
            //
        });
    }
};
