<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Status;
use App\Models\Category;
use App\Models\Department;
use App\Models\MedicalEquipment;
use App\Models\ComputerEquipment;
use App\Models\MedicalEquipmentMovement;
use App\Models\ComputerEquipmentMovement;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $menu = [
            [
                'name' => 'Usuarios',
                'icon' => 'fa-solid fa-users',
                'url' => route('users.index'),
                'access' => auth()->user()->can('viewAny', User::class)
            ],
            [
                'name' => 'Categorías',
                'icon' => 'fa-solid fa-book',
                'url' => route('categories.index'),
                'access' => auth()->user()->can('viewAny', Category::class)
            ],
            [
                'name' => 'Departamentos',
                'icon' => 'fa-solid fa-building',
                'url' => route('departments.index'),
                'access' => auth()->user()->can('viewAny', Department::class)
            ],
            [
                'name' => 'Estados del sistema',
                'icon' => 'fa-solid fa-stethoscope',
                'url' => route('statuses.index'),
                'access' => auth()->user()->can('viewAny', Status::class)
            ],
            [
                'name' => 'Equipos médicos',
                'icon' => 'fa-solid fa-microscope',
                'url' => route('medical-equipments.index'),
                'access' => auth()->user()->can('viewAny', MedicalEquipment::class)
            ],
            [
                'name' => 'Movimientos de equipos médicos',
                'icon' => 'fa-solid fa-repeat',
                'url' => route('medical-equipments-movements.index'),
                'access' => auth()->user()->can('viewAny', MedicalEquipmentMovement::class)
            ],
            [
                'name' => 'Equipos informáticos',
                'icon' => 'fa-solid fa-computer',
                'url' => route('computer-equipments.index'),
                'access' => auth()->user()->can('viewAny', ComputerEquipment::class)
            ],
            [
                'name' => 'Movimientos de equipos informáticos',
                'icon' => 'fa-solid fa-code-compare',
                'url' => route('computer-equipments-movements.index'),
                'access' => auth()->user()->can('viewAny', ComputerEquipmentMovement::class)
            ],
        ];

        return Inertia::render('Dashboard', [
            'menu' => $menu
        ]);
    }
}
