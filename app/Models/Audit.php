<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module',
        'event',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeByUser($query, $user_id)
    {
        if (empty($user_id) || empty($user_id['by_user'])) {
            return $query;
        }

        $query->where('user_id', $user_id);
    }

    public function scopeByModule($query, $module)
    {
        if (empty($module) || empty($module['by_module'])) {
            return $query;
        }

        $query->where('module', $module);
    }

    public function scopeByDates($query, array $dates)
    {
        //
    }


    public static function getModules()
    {
        return [
            ['id' => 'Login',                            'name' => 'Login'],
            ['id' => 'Usuarios',                         'name' => 'Usuarios'],
            ['id' => 'Equipos de cómputo',               'name' => 'Equipos de cómputo'],
            ['id' => 'Movimientos Equipos de cómputo',   'name' => 'Movimientos Equipos de cómputo'],
            ['id' => 'Mantenimiento Equipos de cómputo', 'name' => 'Mantenimiento Equipos de cómputo'],
            ['id' => 'Equipos médicos',                  'name' => 'Equipos médicos'],
            ['id' => 'Movimientos Equipos médicos',      'name' => 'Movimientos Equipos médicos'],
            ['id' => 'Mantenimiento Equipos médicos',    'name' => 'Mantenimiento Equipos médicos'],
        ];
    }

}
