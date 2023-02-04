<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function scopeByMonthYear($query, $monthYear)
    {
        if (empty($monthYear) || empty($monthYear['by_month'])) {
            return $query;
        }

        $collection = Str::of($monthYear['by_month'])->explode('-');
        $date = Carbon::createFromDate($collection[0], $collection[1]);

        $query->whereYear('created_at', $date->format('Y'))->whereMonth('created_at', $date->format('m'));
    }


    public function scopeByRange($query, $range)
    {
        if (empty($range) || empty($range['by_range'])) {
            return $query;
        }

        $startDate = $range['by_range']['startDate'];
        // $endDate = $range['by_range']['endDate'];
        $endDate = Carbon::parse($range['by_range']['endDate']);

        $query->whereBetween('created_at', [$startDate, $endDate->addDays(1)->format('Y-m-d')]);
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
