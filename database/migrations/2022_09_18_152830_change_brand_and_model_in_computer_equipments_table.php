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
        Schema::table('computer_equipments', function (Blueprint $table) {
            $table->dropColumn('brand');
            $table->dropColumn('model');

            $table->foreignId('brand_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('model_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('computer_equipments', function (Blueprint $table) {
            $table->string('brand');
            $table->string('model');

            $table->dropColumn('brand_id');
            $table->dropColumn('model_id');
        });
    }
};
