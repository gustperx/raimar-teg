<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'equipment_id',
        'type',
    ];

    public function equipment()
    {
        if ($this->type == 'medical') {
            return $this->belongsTo(MedicalEquipment::class, $this->equipment_id);
        } else {
            return $this->belongsTo(ComputerEquipment::class, $this->equipment_id);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
