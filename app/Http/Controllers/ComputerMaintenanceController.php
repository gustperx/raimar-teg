<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComputerEquipmentMovement\StoreComputerEquipmentMovementRequest2;
use App\Http\Requests\ComputerEquipmentMovement\UpdateComputerEquipmentMovementRequest2;
use App\Models\ComputerEquipment;
use App\Models\ComputerEquipmentMovement;
use App\Models\Department;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComputerMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $department_informatica = 4;

    public function index(Request $request)
    {
        $this->authorize('viewAny', ComputerEquipmentMovement::class);

        $items = ComputerEquipmentMovement::with(
            'previousDepartment',
            'currentDepartment',
            'userMovement',
            'userResponsible',
            'equipment',
            'status'
        )
            ->where('status_id', '!=', 1)
            ->orderBy('id', 'desc')
            ->statusSearch($request->only('status_search'))
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'previous_department' => $item->previousDepartment->name ?? null,
                    'current_department' => $item->currentDepartment->name ?? null,
                    'user_movement' => $item->userMovement->name ?? null,
                    'user_responsible' => $item->userResponsible->name ?? null,
                    'user_assigned' => $item->user_assigned ?? null,
                    'equipment' => $item->equipment->only('id', 'description', 'code', 'serial') ?? null,
                    'status' => $item->status->name ?? null,
                    'status_color' => $item->status->color ?? null,
                    'transfer_date' => $item->transfer_date,
                    'incidence' => $item->incidence,
                    'edit_url' => route('computer-maintenance.edit', $item),
                    'can' => [
                        'edit' => auth()->user()->can('update', $item),
                    ]
                ];
            });

        return Inertia::render('ComputerMaintenance/Index', [
            'filters' => [
                'status_search' => $request->only('status_search'),
            ],
            'items' => $items,
            'urls' => [
                'create_url' => route('computer-maintenance.create'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', ComputerEquipmentMovement::class),
            ],
            'statusesList' => Status::select('id', 'name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', ComputerEquipmentMovement::class);

        $usersTech = User::getDepartmentList($this->department_informatica);
        $statuses = Status::select('id', 'name')->where('id', '!=', 1)->get();
        $equipments = ComputerEquipment::getEquipmentList();
        $departments = Department::select('id', 'name')->where('id', $this->department_informatica)->get();

        return Inertia::render('ComputerMaintenance/Add', [
            'equipments' => $equipments,
            'statuses' => $statuses,
            'users' => $usersTech,
            'usersTech' => $usersTech,
            'departments' => $departments,
            'return_url' => route('computer-maintenance.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreComputerEquipmentMovementRequest2  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComputerEquipmentMovementRequest2 $request)
    {
        $this->authorize('create', ComputerEquipmentMovement::class);

        $equipment = ComputerEquipment::find($request->input('equipment_id'));

        $data = $request->all();
        $data['previous_department_id'] = $equipment->department_id;

        $movement = ComputerEquipmentMovement::create($data);

        $equipment->update([
            'status_id' => $data['status_id'],
            'department_id' => $data['current_department_id'],
        ]);

        $request->session()->flash('success', 'Mantenimiento de equipo creado satisfactoriamente');
        return redirect()->route('computer-maintenance.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function edit($computerEquipmentMovement_id)
    {
        $computerEquipmentMovement = ComputerEquipmentMovement::with(
            'equipment',
            'userMovement',
            'userResponsible',
        )->find($computerEquipmentMovement_id);

        $this->authorize('update', $computerEquipmentMovement);

        $usersTech = User::getDepartmentList($this->department_informatica);
        $statuses = Status::select('id', 'name')->where('id', '!=', 2)->get();
        $equipments = ComputerEquipment::getEquipmentMaintenanceList();
        $departments = Department::select('id', 'name')->where('id', $this->department_informatica)->get();

        $current_equipment = [
            'id' => $computerEquipmentMovement->equipment->id ?? null,
            'name' => $computerEquipmentMovement->equipment->code ?? null
        ];

        return Inertia::render('ComputerMaintenance/Edit', [
            'computerEquipmentMovement' => $computerEquipmentMovement->only(
                'id',
                'previous_department_id',
                'current_department_id',
                'user_movement_id',
                'user_responsible_id',
                'user_assigned',
                'equipment_id',
                'status_id',
                'transfer_date',
                'incidence',
                'period_start',
                'period_end',
            ),
            'current_equipment' => $current_equipment,
            'user_movement' => $computerEquipmentMovement->userMovement->only('id', 'name'),
            'user_responsible' => $computerEquipmentMovement->userResponsible->only('id', 'name'),
            /* 'user_assigned' => $computerEquipmentMovement->userAssigned->only('id', 'name'), */
            'equipments' => $equipments,
            'statuses' => $statuses,
            'users' => $usersTech,
            'usersTech' => $usersTech,
            'departments' => $departments,
            'return_url' => route('computer-maintenance.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComputerEquipmentMovementRequest2  $request
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComputerEquipmentMovementRequest2 $request, $computerEquipmentMovement_id)
    {
        $computerEquipmentMovement = ComputerEquipmentMovement::find($computerEquipmentMovement_id);

        $this->authorize('update', $computerEquipmentMovement);

        $equipment = ComputerEquipment::find($request->input('equipment_id'));

        $data = $request->all();

        $computerEquipmentMovement->update($data);

        $equipment->update([
            'status_id' => $data['status_id'],
            'department_id' => $data['current_department_id'],
        ]);

        $request->session()->flash('success', 'Mantenimiento de equipo actualizado satisfactoriamente');
        return redirect()->route('computer-maintenance.index');
    }
}
