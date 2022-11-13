<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Audit;
use App\Models\Status;
use App\Models\Category;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\MedicalEquipment;
use App\Models\ComputerEquipment;
use App\Models\MedicalEquipmentMovement;
use App\Models\ComputerEquipmentMovement;

class DashboardController extends Controller
{

    public function index()
    {
        // TODO: Permisos en "Registro"
        $isAccessRegistro = auth()->user()->hasAnyPermission([
            'manager:user-create',
            'technical:computerEquipments-create',
            'technical:medicalEquipments-create',
            'technical:computerEquipments-read',
            'technical:medicalEquipments-read',
        ]);

        // TODO: Permisos en "Informática"
        $isAccessInformatica = auth()->user()->hasAnyPermission([
            'technical:computerEquipments-maintenance',
            'technical:computerEquipmentMovements-read',
        ]);

        // TODO: Permisos en "Operaciones"
        $isAccessOperaciones = auth()->user()->hasAnyPermission([
            'technical:medicalEquipments-maintenance',
            'technical:medicalEquipmentMovements-read',
        ]);

        // TODO: Permisos en "Estadísticas"
        $hasStats = auth()->user()->hasAnyPermission([
            'technical:computerEquipments-read',
            'technical:medicalEquipments-read',
        ]);

        $menu = [
            [
                'name' => 'Registro',
                'icon' => 'fa-solid fa-users',
                'url' => route('d_register'),
                'access' => $isAccessRegistro
            ],
            [
                'name' => 'Informática',
                'icon' => 'fa-solid fa-computer',
                'url' => route('d_informatica'),
                'access' => $isAccessInformatica
            ],
            [
                'name' => 'Operaciones',
                'icon' => 'fa-solid fa-microscope',
                'url' => route('d_operations'),
                'access' => $isAccessOperaciones
            ],
            [
                'name' => 'Roles de Usuarios',
                'icon' => 'fa-solid fa-users',
                'url' => route('d_roles'),
                'access' => auth()->user()->can('viewAny', User::class)
            ],
            [
                'name' => 'Estadísticas',
                'icon' => 'fa-solid fa-chart-line',
                'url' => route('stats'),
                'access' => $hasStats
            ],
            [
                'name' => 'Disponibilidad de equipos',
                'icon' => 'fab fa-searchengin',
                'url' => route('d_available'),
                'access' => true
            ],
            [
                'name' => 'Auditoria',
                'icon' => 'fas fa-tasks',
                'url' => route('audis.index'),
                'access' => auth()->user()->can('viewAny', Audit::class)
            ],
            [
                'name' => 'Ayuda',
                'icon' => 'fa-solid fa-circle-question',
                'url' => "#",
                'access' => true
            ],
        ];

        return Inertia::render('Dashboard', [
            'menu' => $menu,
            'activeBack' => false,
            'return_url' => '',
        ]);
    }


    public function register()
    {
        // TODO: Validar permisos para acceder a estados de equipos
        $hasStatus = auth()->user()->hasAnyPermission([
            'technical:computerEquipments-read',
            'technical:medicalEquipments-read',
        ]);

        $menu = [
            [
                'name' => 'Registro de Usuarios',
                'icon' => 'fa-solid fa-users',
                'url' => route('users.create'),
                'access' => auth()->user()->can('create', User::class)
            ],
            [
                'name' => 'Equipos informáticos',
                'icon' => 'fa-solid fa-computer',
                'url' => route('computer-equipments.create'),
                'access' => auth()->user()->can('create', ComputerEquipment::class)
            ],
            [
                'name' => 'Equipos médicos',
                'icon' => 'fa-solid fa-microscope',
                'url' => route('medical-equipments.create'),
                'access' => auth()->user()->can('create', MedicalEquipment::class)
            ],
            [
                'name' => 'Estatus de equipos',
                'icon' => 'fa-solid fa-stethoscope',
                'url' => route('d_status'),
                'access' => $hasStatus
            ],
        ];

        return Inertia::render('Dashboard', [
            'menu' => $menu,
            'activeBack' => true,
            'return_url' => route('dashboard'),
        ]);
    }


    public function status()
    {
        $menu = [
            [
                'name' => 'Equipos informáticos',
                'icon' => 'fa-solid fa-computer',
                'url' => route('computer-equipments.index'),
                'access' => auth()->user()->can('viewAny', ComputerEquipment::class)
            ],
            [
                'name' => 'Equipos médicos',
                'icon' => 'fa-solid fa-microscope',
                'url' => route('medical-equipments.index'),
                'access' => auth()->user()->can('viewAny', MedicalEquipment::class)
            ],
        ];

        return Inertia::render('Dashboard', [
            'menu' => $menu,
            'activeBack' => true,
            'return_url' => route('d_register'),
        ]);
    }


    public function informatica()
    {
        $menu = [
            [
                'name' => 'Movimientos de equipos informáticos',
                'icon' => 'fa-solid fa-code-compare',
                'url' => route('computer-equipments-movements.index'),
                'access' => auth()->user()->can('viewAny', ComputerEquipmentMovement::class)
            ],
            [
                'name' => 'Mantenimiento Equipos informáticos',
                'icon' => 'fa-solid fa-bug',
                'url' => route('computer-maintenance.index'),
                'access' => auth()->user()->can('maintenance', ComputerEquipment::class)
            ],
        ];

        return Inertia::render('Dashboard', [
            'menu' => $menu,
            'activeBack' => true,
            'return_url' => route('dashboard'),
        ]);
    }


    public function operations()
    {
        $menu = [
            [
                'name' => 'Movimientos de equipos médicos',
                'icon' => 'fa-solid fa-repeat',
                'url' => route('medical-equipments-movements.index'),
                'access' => auth()->user()->can('viewAny', MedicalEquipmentMovement::class)
            ],
            [
                'name' => 'Mantenimiento Equipos médicos',
                'icon' => 'fa-solid fa-screwdriver-wrench',
                'url' => route('medical-maintenance.index'),
                'access' => auth()->user()->can('maintenance', MedicalEquipment::class)
            ],
        ];

        return Inertia::render('Dashboard', [
            'menu' => $menu,
            'activeBack' => true,
            'return_url' => route('dashboard'),
        ]);
    }


    public function roles()
    {
        $menu = [
            [
                'name' => 'Usuarios',
                'icon' => 'fa-solid fa-users',
                'url' => route('users.index'),
                'access' => auth()->user()->can('viewAny', User::class)
            ],
        ];

        return Inertia::render('Dashboard', [
            'menu' => $menu,
            'activeBack' => true,
            'return_url' => route('dashboard'),
        ]);
    }


    public function available()
    {
        $menu = [
            [
                'name' => 'Equipos informáticos',
                'icon' => 'fa-solid fa-computer',
                'url' => route('computer-equipments.available'),
                'access' => true
            ],
            [
                'name' => 'Equipos médicos',
                'icon' => 'fa-solid fa-microscope',
                'url' => route('medical-equipments.available'),
                'access' => true
            ],
        ];

        return Inertia::render('Dashboard', [
            'menu' => $menu,
            'activeBack' => true,
            'return_url' => route('dashboard'),
        ]);
    }


    private function old_menu()
    {
        $menu = [
            [
                'name' => 'Usuarios',
                'icon' => 'fa-solid fa-users',
                'url' => route('users.index'),
                'access' => auth()->user()->can('viewAny', User::class)
            ],
            [
                'name' => 'Categorías de equipos',
                'icon' => 'fa-solid fa-book',
                'url' => route('categories.index'),
                'access' => auth()->user()->can('viewAny', Category::class)
            ],
            [
                'name' => 'Departamentos y Unidades',
                'icon' => 'fa-solid fa-building',
                'url' => route('departments.index'),
                'access' => auth()->user()->can('viewAny', Department::class)
            ],
            [
                'name' => 'Estados de equipos',
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

            [
                'name' => 'Mantenimiento Equipos médicos',
                'icon' => 'fa-solid fa-screwdriver-wrench',
                'url' => route('medical-maintenance.index'),
                'access' => auth()->user()->can('maintenance', MedicalEquipment::class)
            ],
            [
                'name' => 'Mantenimiento Equipos informáticos',
                'icon' => 'fa-solid fa-bug',
                'url' => route('computer-maintenance.index'),
                'access' => auth()->user()->can('maintenance', ComputerEquipment::class)
            ],
            [
                'name' => 'Estadísticas',
                'icon' => 'fa-solid fa-chart-line',
                'url' => route('stats'),
                'access' => true
            ],
        ];
    }
}
