<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalEquipmentMovement extends Model
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

    public function previousDepartment()
    {
        return $this->belongsTo(Department::class, $this->previous_department_id);
    }

    public function currentDepartment()
    {
        return $this->belongsTo(Department::class, $this->current_department_id);
    }

    public function userMovement()
    {
        return $this->belongsTo(User::class, $this->user_movement_id);
    }

    public function userResponsible()
    {
        return $this->belongsTo(User::class, $this->user_responsible_id);
    }

    public function userAssigned()
    {
        return $this->belongsTo(User::class, $this->user_assigned_id);
    }

    public function equipment()
    {
        return $this->belongsTo(MedicalEquipment::class, $this->equipment_id);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('incidence', 'like', '%' . $search . '%');
            });
        });
    }
}
