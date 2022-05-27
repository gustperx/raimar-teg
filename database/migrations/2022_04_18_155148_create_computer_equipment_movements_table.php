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
        Schema::create('computer_equipment_movements', function (Blueprint $table) {
            $table->id();

            $table->foreignId('current_department_id')->constrained('departments')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('status_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('equipment_id')->constrained('computer_equipments')->cascadeOnUpdate()->cascadeOnDelete();
            
            $table->foreignId('previous_department_id')->constrained('departments')->cascadeOnUpdate()->cascadeOnDelete()->nullable();
            $table->foreignId('user_movement_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete()->nullable()->nullable();
            $table->foreignId('user_responsible_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete()->nullable()->nullable();
            
            $table->text('user_assigned')->nullable();
            $table->timestamp('transfer_date');
            $table->longText('incidence');
            
            $table->softDeletes();
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
        Schema::dropIfExists('computer_equipment_movements');
    }
};
