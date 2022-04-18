<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComputerEquipmentMovement extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'previous_department_id',
        'current_department_id',
        'user_movement_id',
        'user_responsible_id',
        'user_assigned_id',
        'equipment_id',
        'status_id',
        'transfer_date',
        'incidence',
    ];
}
