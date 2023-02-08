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
            $table->string('serial_number', 50)->nullable()->after('batch');
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
            $table->dropColumn('serial_number');
        });
    }
};
