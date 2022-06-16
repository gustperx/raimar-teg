<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\MedicalEquipment;
use App\Models\ComputerEquipment;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{    
    public function index () 
    {
        $medicalEquipmentData = MedicalEquipment::getStatsEquipmentStatus();
        $computerEquipmentData = ComputerEquipment::getStatsEquipmentStatus();
        $dMedical = $this->getMedicalEquipmentByDepartment();
        $dComputer = $this->getComputerEquipmentByDepartment();

        return Inertia::render('Stats/Report', [
            'medicalEquipmentData' => $medicalEquipmentData,
            'computerEquipmentData' => $computerEquipmentData,
            'dMedical' => $dMedical,
            'dComputer' => $dComputer,
        ]);
    }


    private function getMedicalEquipmentByDepartment()
    {
        $departments = Department::where('id', '>', 2)->pluck('name', 'id');

        $dMedical = DB::table('medical_equipments')
                        ->select('department_id', DB::raw('count(*) as total'))
                        ->groupBy('department_id')
                        ->pluck('total', 'department_id');

        $dep = [];
        $equipment = [];
        foreach ($dMedical as $key => $value) {
            $dep[] = $departments[$key];
            $equipment[] = $value;
        }

        return [
            'labels' => $dep,
            'datasets' => [
                [
                    'data' => $equipment,
                    'label' => "Distribución de equipos medicos y departamentos", 
                    'backgroundColor' => "#f87979"
                ],
            ],
        ];
    }

    private function getComputerEquipmentByDepartment()
    {
        $departments = Department::where('id', '>', 2)->pluck('name', 'id');

        $dComputer = DB::table('computer_equipments')
                        ->select('department_id', DB::raw('count(*) as total'))
                        ->groupBy('department_id')
                        ->pluck('total', 'department_id');

        $dep = [];
        $equipment = [];
        foreach ($dComputer as $key => $value) {
            $dep[] = $departments[$key];
            $equipment[] = $value;
        }

        return [
            'labels' => $dep,
            'datasets' => [
                [
                    'data' => $equipment,
                    'label' => "Distribución de equipos informáticos y departamentos", 
                    'backgroundColor' => "#f87979"
                ],
            ],
        ];
    }
}
