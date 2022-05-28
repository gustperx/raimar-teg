<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Operativo', 'color' => '#80df0c'],
            ['name' => 'Mantenimiento', 'color' => '#e4d211'],
            ['name' => 'Fuera de servicio', 'color' => '#e40c0c'],
        ];

        foreach ($statuses as $status) {
            Status::create($status);
        }
    }
}
