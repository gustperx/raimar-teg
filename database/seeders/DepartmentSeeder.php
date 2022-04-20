<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departmentOne = Department::create([
            'name' => 'Departamento'
        ]);

        $departmentTwo = Department::create([
            'name' => 'Unidad médica'
        ]);

        $departments = [
            'Logística',
            'Informática',
            'Contraloría General',
            'Finanzas',
            'Contabilidad',
            'Compras',
            'Recursos Humanos',
            'Credito y Cobranza',
            'APS',
            'Almacén',
            'Admisión',
            'Laboral',
            'Facturación',
            'Caja',
            'Admisión Hospitalización',
            'Gerencia de Enfermeria',
            'Electromedicina',

        ];

        $unidades = [
            'Laboratorio',
            'Estar Principal de Enfermeria',
            'Emergencia',
            'Imagen',
            'Habitaciones',
            'Quirófano',
            'UCI',
            'Recuperación',
            'Consultorios',
            'Unidosis',
            'Rayos X',
            'Vigilancia',
            'Almacenes',
            'Operaciones',
            'Gastro',
            'Banco de Sangre',
            'Neonatología',

        ];

        foreach ($departments as $department) {
            Department::create([
                'name' => $department,
                'parent_id' => $departmentOne->id
            ]);
        }

        foreach ($unidades as $unida) {
            Department::create([
                'name' => $unida,
                'parent_id' => $departmentTwo->id
            ]);
        }
    }
}
