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
        Schema::table('persediaan_awal', function (Blueprint $table) {
            $table->date('tgl_persediaan_awal')->after('lokasi_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persediaan_awal', function (Blueprint $table) {
            $table->dropColumn(['tgl_persediaan_awal']);
        });
    }
};
