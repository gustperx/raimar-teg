<?php

namespace Database\Seeders;

use App\Models\ComputerEquipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComputerEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ComputerEquipment::create([
            'category_id' => '3',
            'status_id' => '1',
            'code' => 'CCINF001',
            'description' => 'PC 1',
            'brand' => 'Lenovo',
            'model' => 'ThinkCenter',
            'serial' => 'ABC1234568',
        ]);

        ComputerEquipment::create([
            'category_id' => '4',
            'status_id' => '2',
            'code' => 'CCINF002',
            'description' => 'Teclado Microsoft',
            'brand' => 'Microsoft',
            'model' => 'Keyboard 400',
            'serial' => 'ABC98765432',
        ]);
    }
}
