<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Carbon;

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
        'user_assigned',
        'equipment_id',
        'status_id',
        'transfer_date',
        'incidence',
        'period',
        'period_start',
        'period_end',
    ];

    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function transferDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }

    protected function periodStart(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }

    protected function periodEnd(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d/m/Y'),
        );
    }

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

    public function equipment()
    {
        return $this->belongsTo(ComputerEquipment::class, $this->equipment_id);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function scopeEquipmentSearch($query, array $filters)
    {
        $query->when($filters['equipment_search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('equipment_id', $search);
            });
        });
    }

    public function scopePersonalSearch($query, array $filters)
    {
        $query->when($filters['personal_search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('user_movement_id', $search)
                    ->orWhere('user_responsible_id', $search);
            });
        });
    }

    public function scopeDepartmentSearch($query, array $filters)
    {
        $query->when($filters['department_search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('previous_department_id', $search)
                    ->orWhere('current_department_id', $search);
            });
        });
    }

    public function scopeStatusSearch($query, array $filters)
    {
        $query->when($filters['status_search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where('status_id', $search);
            });
        });
    }
}
