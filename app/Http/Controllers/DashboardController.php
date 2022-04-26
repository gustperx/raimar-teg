<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Category;
use App\Models\ComputerEquipment;
use App\Models\ComputerEquipmentMovement;
use App\Models\Department;
use App\Models\MedicalEquipment;
use App\Models\MedicalEquipmentMovement;
use App\Models\Status;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $menu = [
            [
                'name' => 'Categorías',
                'icon' => 'fa-solid fa-book',
                'url' => route('categories.index'),
                'access' => auth()->user()->can('viewAny', Category::class)
            ],
            [
                'name' => 'Departamentos',
                'icon' => 'fa-solid fa-book',
                'url' => route('departments.index'),
                'access' => auth()->user()->can('viewAny', Department::class)
            ],
            [
                'name' => 'Estados del sistema',
                'icon' => 'fa-solid fa-book',
                'url' => route('statuses.index'),
                'access' => auth()->user()->can('viewAny', Status::class)
            ],
            [
                'name' => 'Equipos médicos',
                'icon' => 'fa-solid fa-book',
                'url' => route('medical-equipments.index'),
                'access' => auth()->user()->can('viewAny', MedicalEquipment::class)
            ],
            [
                'name' => 'Movimientos de equipos médicos',
                'icon' => 'fa-solid fa-book',
                'url' => route('medical-equipments-movements.index'),
                'access' => auth()->user()->can('viewAny', MedicalEquipmentMovement::class)
            ],
            [
                'name' => 'Equipos informáticos',
                'icon' => 'fa-solid fa-book',
                'url' => route('computer-equipments.index'),
                'access' => auth()->user()->can('viewAny', ComputerEquipment::class)
            ],
            [
                'name' => 'Movimientos de equipos informáticos',
                'icon' => 'fa-solid fa-book',
                'url' => route('computer-equipments-movements.index'),
                'access' => auth()->user()->can('viewAny', ComputerEquipmentMovement::class)
            ],
        ];

        return Inertia::render('Dashboard', [
            'menu' => $menu
        ]);
    }
}
