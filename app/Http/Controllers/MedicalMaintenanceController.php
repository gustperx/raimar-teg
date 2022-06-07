<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalEquipmentMovement\StoreMedicalEquipmentMovementRequest2;
use App\Http\Requests\MedicalEquipmentMovement\UpdateMedicalEquipmentMovementRequest2;
use App\Models\Department;
use App\Models\MedicalEquipment;
use App\Models\MedicalEquipmentMovement;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MedicalMaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $department_logistica = 3;

    public function index(Request $request)
    {
        $this->authorize('viewAny', MedicalEquipmentMovement::class);

        $items = MedicalEquipmentMovement::with(
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
                    'updated_at' => $item->updated_at->format('d/m/Y H:i'),
                    'edit_url' => route('medical-maintenance.edit', $item),
                    'can' => [
                        'edit' => auth()->user()->can('update', $item),
                    ]
                ];
            });

        return Inertia::render('MedicalMaintenance/Index', [
            'filters' => [
                'status_search' => $request->only('status_search'),
            ],
            'items' => $items,
            'urls' => [
                'create_url' => route('medical-maintenance.create'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', MedicalEquipmentMovement::class),
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
        $this->authorize('create', MedicalEquipmentMovement::class);

        $usersTech = User::getDepartmentList($this->department_logistica);
        $statuses = Status::select('id', 'name')->where('id', '!=', 1)->get();
        $equipments = MedicalEquipment::getEquipmentList();
        $departments = Department::select('id', 'name')->whereIn('id', [3, 19])->get();

        return Inertia::render('MedicalMaintenance/Add', [
            'equipments' => $equipments,
            'statuses' => $statuses,
            'users' => $usersTech,
            'usersTech' => $usersTech,
            'departments' => $departments,
            'return_url' => route('medical-maintenance.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMedicalEquipmentMovementRequest2  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicalEquipmentMovementRequest2 $request)
    {
        $this->authorize('create', MedicalEquipmentMovement::class);

        $equipment = MedicalEquipment::find($request->input('equipment_id'));

        $data = $request->all();
        $data['previous_department_id'] = $equipment->department_id;

        $movement = MedicalEquipmentMovement::create($data);

        $equipment->update([
            'status_id' => $data['status_id'],
            'department_id' => $data['current_department_id'],
        ]);

        $request->session()->flash('success', 'Mantenimiento de equipo creado satisfactoriamente');
        return redirect()->route('medical-maintenance.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function edit($medicalEquipmentMovement_id)
    {
        $medicalEquipmentMovement = MedicalEquipmentMovement::with(
            'equipment',
            'userMovement',
            'userResponsible',
        )->find($medicalEquipmentMovement_id);

        $this->authorize('update', $medicalEquipmentMovement);

        $usersTech = User::getDepartmentList($this->department_logistica);
        $statuses = Status::select('id', 'name')->where('id', '!=', 2)->get();
        $equipments = MedicalEquipment::getEquipmentMaintenanceList();
        $departments = Department::select('id', 'name')->whereIn('id', [3, 19])->get();

        $current_equipment = [
            'id' => $medicalEquipmentMovement->equipment->id ?? null,
            'name' => $medicalEquipmentMovement->equipment->code ?? null
        ];

        return Inertia::render('MedicalMaintenance/Edit', [
            'medicalEquipmentMovement' => $medicalEquipmentMovement->only(
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
            'user_movement' => $medicalEquipmentMovement->userMovement->only('id', 'name'),
            'user_responsible' => $medicalEquipmentMovement->userResponsible->only('id', 'name'),
            /* 'user_assigned' => $medicalEquipmentMovement->userAssigned->only('id', 'name'), */
            'equipments' => $equipments,
            'statuses' => $statuses,
            'users' => $usersTech,
            'usersTech' => $usersTech,
            'departments' => $departments,
            'return_url' => route('medical-maintenance.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMedicalEquipmentMovementRequest2  $request
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMedicalEquipmentMovementRequest2 $request, $medicalEquipmentMovement_id)
    {
        $medicalEquipmentMovement = MedicalEquipmentMovement::find($medicalEquipmentMovement_id);

        $this->authorize('update', $medicalEquipmentMovement);

        $equipment = MedicalEquipment::find($request->input('equipment_id'));

        $data = $request->all();

        $movement = $medicalEquipmentMovement->update($data);

        $equipment->update([
            'status_id' => $data['status_id'],
            'department_id' => $data['current_department_id'],
        ]);

        $request->session()->flash('success', 'Mantenimiento de equipo actualizado satisfactoriamente');
        return redirect()->route('medical-maintenance.index');
    }

}
