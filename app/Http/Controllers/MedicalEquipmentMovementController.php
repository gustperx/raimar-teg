<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalEquipmentMovement\StoreMedicalEquipmentMovementRequest;
use App\Http\Requests\MedicalEquipmentMovement\UpdateMedicalEquipmentMovementRequest;
use App\Models\Department;
use App\Models\MedicalEquipment;
use App\Models\MedicalEquipmentMovement;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MedicalEquipmentMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $department_logistica = [19, 33];
    private $department_medical = 2;

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
            ->orderBy('id', 'desc')
            ->equipmentSearch($request->only('equipment_search'))
            ->personalSearch($request->only('personal_search'))
            ->departmentSearch($request->only('department_search'))
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
                    'edit_url' => route('medical-equipments-movements.edit', $item),
                    'show_url' => route('medical-equipments-movements.show', $item),
                    'can' => [
                        'show' => auth()->user()->can('view', $item),
                        'edit' => auth()->user()->can('update', $item),
                        'delete' => auth()->user()->can('delete', $item),
                    ]
                ];
            });

        $usersTech = User::getDepartmentList($this->department_logistica);
        $users = User::getDepartmentList(null, $this->department_medical);

        return Inertia::render('MedicalEquipmentMovements/Index', [
            'filters' => [
                'equipment_search' => $request->only('equipment_search'),
                'personal_search' => $request->only('personal_search'),
                'department_search' => $request->only('department_search'),
                'status_search' => $request->only('status_search'),
            ],
            'items' => $items,
            'urls' => [
                'create_url' => route('medical-equipments-movements.create'),
                'restore_url' => route('medical-equipments-movements.trash'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', MedicalEquipmentMovement::class),
                'restore' => auth()->user()->can('restoreAny', MedicalEquipmentMovement::class),
            ],
            'equipmentsList' => MedicalEquipment::getEquipmentList(),
            'personalList' => array_merge($usersTech, $users),
            'statusesList' => Status::select('id', 'name')->get(),
            'departmentsList' => Department::select('id', 'name')->where('parent_id', $this->department_medical)->get(),
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
        $users = User::getDepartmentList(null, $this->department_medical);

        $statuses = Status::select('id', 'name')->get();
        $equipments = MedicalEquipment::getEquipmentList();
        $departments = Department::select('id', 'name')->where('parent_id', $this->department_medical)->get();

        return Inertia::render('MedicalEquipmentMovements/Add', [
            'equipments' => $equipments,
            'statuses' => $statuses,
            'users' => $users,
            'usersTech' => $usersTech,
            'departments' => $departments,
            'return_url' => route('medical-equipments-movements.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMedicalEquipmentMovementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicalEquipmentMovementRequest $request)
    {
        $this->authorize('create', MedicalEquipmentMovement::class);

        $equipment = MedicalEquipment::find($request->input('equipment_id'));

        $data = $request->all();
        $data['previous_department_id'] = $equipment->department_id;
        $data['status_id'] = 1; // active

        $movement = MedicalEquipmentMovement::create($data);

        $equipment->update([
            'status_id' => 1,
            'department_id' => $data['current_department_id'],
        ]);

        $request->session()->flash('success', 'Trasladó de equipo creado satisfactoriamente');
        return redirect()->route('medical-equipments-movements.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function show($medicalEquipmentMovement_id)
    {
        $medicalEquipmentMovement = MedicalEquipmentMovement::find($medicalEquipmentMovement_id);

        $this->authorize('view', $medicalEquipmentMovement);

        $medicalEquipmentMovement = MedicalEquipmentMovement::with(
            'previousDepartment',
            'currentDepartment',
            'userMovement',
            'userResponsible',
            'equipment',
            'status'
        )
            ->where('id', $medicalEquipmentMovement->id)->first();

        $medicalEquipmentMovement = [
            'id' => $medicalEquipmentMovement->id,
            'previous_department' => $medicalEquipmentMovement->previousDepartment->name ?? null,
            'current_department' => $medicalEquipmentMovement->currentDepartment->name ?? null,
            'user_movement' => $medicalEquipmentMovement->userMovement->name ?? null,
            'user_responsible' => $medicalEquipmentMovement->userResponsible->name ?? null,
            'user_assigned' => $medicalEquipmentMovement->user_assigned ?? null,
            'equipment' => $medicalEquipmentMovement->equipment->only('id', 'description', 'code', 'serial') ?? null,
            'status' => $medicalEquipmentMovement->status->name ?? null,
            'transfer_date' => $medicalEquipmentMovement->transfer_date,
            'incidence' => $medicalEquipmentMovement->incidence,
            'period_start' => $medicalEquipmentMovement->period_start,
            'period_end' => $medicalEquipmentMovement->period_end,
        ];

        return Inertia::render('MedicalEquipmentMovements/Show', [
            'return_url' => route('medical-equipments-movements.index'),
            'medicalEquipmentMovement' => $medicalEquipmentMovement,
        ]);
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
        $users = User::getDepartmentList(null, $this->department_medical);

        $statuses = Status::select('id', 'name')->get();
        $equipments = MedicalEquipment::getEquipmentList();
        $departments = Department::select('id', 'name')->where('parent_id', $this->department_medical)->get();

        $current_equipment = [
            'id' => $medicalEquipmentMovement->equipment->id ?? null,
            'name' => $medicalEquipmentMovement->equipment->code ?? null
        ];

        return Inertia::render('MedicalEquipmentMovements/Edit', [
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
            'users' => $users,
            'usersTech' => $usersTech,
            'departments' => $departments,
            'return_url' => route('medical-equipments-movements.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMedicalEquipmentMovementRequest  $request
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMedicalEquipmentMovementRequest $request, $medicalEquipmentMovement_id)
    {
        $medicalEquipmentMovement = MedicalEquipmentMovement::find($medicalEquipmentMovement_id);

        $this->authorize('update', $medicalEquipmentMovement);

        $equipment = MedicalEquipment::find($request->input('equipment_id'));

        $data = $request->all();

        $movement = $medicalEquipmentMovement->update($data);

        $equipment->update([
            'department_id' => $data['current_department_id'],
        ]);

        $request->session()->flash('success', 'Trasladó de equipo actualizado satisfactoriamente');
        return redirect()->route('medical-equipments-movements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $medicalEquipmentMovement_id)
    {
        $medicalEquipmentMovement = MedicalEquipmentMovement::find($medicalEquipmentMovement_id);

        $this->authorize('delete', $medicalEquipmentMovement);

        $medicalEquipmentMovement->delete();

        $request->session()->flash('info', 'Trasladó de equipo eliminado satisfactoriamente');
        return redirect()->route('medical-equipments-movements.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->authorize('restoreAny', MedicalEquipmentMovement::class);

        $items = MedicalEquipmentMovement::with(
            'previousDepartment',
            'currentDepartment',
            'userMovement',
            'userResponsible',
            'equipment',
            'status'
        )
            ->onlyTrashed()
            ->orderBy('id', 'desc')
            ->equipmentSearch($request->only('equipment_search'))
            ->personalSearch($request->only('personal_search'))
            ->departmentSearch($request->only('department_search'))
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
                    'transfer_date' => $item->transfer_date,
                    'incidence' => $item->incidence,
                    'can' => [
                        'restore' => auth()->user()->can('restore', $item),
                        'forceDelete' => auth()->user()->can('forceDelete', $item),
                    ]
                ];
            });

        $usersTech = User::getDepartmentList($this->department_logistica);
        $users = User::getDepartmentList(null, $this->department_medical);

        return Inertia::render('MedicalEquipmentMovements/Trash', [
            'filters' => [
                'equipment_search' => $request->only('equipment_search'),
                'personal_search' => $request->only('personal_search'),
                'department_search' => $request->only('department_search'),
                'status_search' => $request->only('status_search'),
            ],
            'items' => $items,
            'urls' => [
                'return_url' => route('medical-equipments-movements.index'),
            ],
            'equipmentsList' => MedicalEquipment::getEquipmentList(),
            'personalList' => array_merge($usersTech, $users),
            'statusesList' => Status::select('id', 'name')->get(),
            'departmentsList' => Department::select('id', 'name')->where('parent_id', $this->department_medical)->get(),
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $medicalEquipmentMovement_id)
    {
        $medicalEquipmentMovement = MedicalEquipmentMovement::onlyTrashed()->find($medicalEquipmentMovement_id);

        $this->authorize('restore', $medicalEquipmentMovement);

        $medicalEquipmentMovement->restore();

        $request->session()->flash('success', 'Trasladó de equipo restaurado satisfactoriamente');
        return redirect()->route('medical-equipments-movements.trash');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function trashDestroy(Request $request, $medicalEquipmentMovement_id)
    {
        $medicalEquipmentMovement = MedicalEquipmentMovement::onlyTrashed()->find($medicalEquipmentMovement_id);

        $this->authorize('forceDelete', $medicalEquipmentMovement);

        $medicalEquipmentMovement->forceDelete();

        $request->session()->flash('warn', 'Trasladó de equipo eliminado definitivamente');
        return redirect()->route('medical-equipments-movements.trash');
    }
}
