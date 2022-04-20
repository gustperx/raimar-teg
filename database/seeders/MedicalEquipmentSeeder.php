<?php

namespace Database\Seeders;

use App\Models\MedicalEquipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicalEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MedicalEquipment::create([
            'category_id' => '27',
            'status_id' => '1',
            'code' => 'CCINF1000',
            'description' => 'Resonador',
            'brand' => 'Marca 1',
            'model' => 'Modelo 2',
            'serial' => 'PPP1234568',
        ]);
    }
}
