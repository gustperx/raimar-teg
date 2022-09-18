<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'type'];


    /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::lower($value),
        );
    }


    public function computerEquipments()
    {
        return $this->hasMany(ComputerEquipment::class);
    }

    public function medicalEquipments()
    {
        return $this->hasMany(MedicalEquipment::class);
    }
}
