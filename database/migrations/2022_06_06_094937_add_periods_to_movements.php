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
        Schema::table('computer_equipment_movements', function (Blueprint $table) {
            $table->timestamp('period_start')->nullable();
            $table->timestamp('period_end')->nullable();
        });

        Schema::table('medical_equipment_movements', function (Blueprint $table) {
            $table->timestamp('period_start')->nullable();
            $table->timestamp('period_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('computer_equipment_movements', function (Blueprint $table) {
            $table->dropColumn('period_start');
            $table->dropColumn('period_end');
        });

        Schema::table('medical_equipment_movements', function (Blueprint $table) {
            $table->dropColumn('period_start');
            $table->dropColumn('period_end');
        });
    }
};
