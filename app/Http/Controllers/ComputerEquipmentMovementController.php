<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComputerEquipmentMovement\StoreComputerEquipmentMovementRequest;
use App\Http\Requests\ComputerEquipmentMovement\UpdateComputerEquipmentMovementRequest;
use App\Models\ComputerEquipment;
use App\Models\ComputerEquipmentMovement;
use App\Models\Department;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComputerEquipmentMovementController extends Controller
{
    private $department_informatica = 4;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
                    'edit_url' => route('computer-equipments-movements.edit', $item),
                    'show_url' => route('computer-equipments-movements.show', $item),
                    'can' => [
                        'show' => auth()->user()->can('view', $item),
                        'edit' => auth()->user()->can('update', $item),
                        'delete' => auth()->user()->can('delete', $item),
                    ]
                ];
            });

        $usersTech = User::getDepartmentList($this->department_informatica);
        $users = User::getDepartmentList();

        return Inertia::render('ComputerEquipmentMovements/Index', [
            'filters' => [
                'equipment_search' => $request->only('equipment_search'),
                'personal_search' => $request->only('personal_search'),
                'department_search' => $request->only('department_search'),
                'status_search' => $request->only('status_search'),
            ],
            'items' => $items,
            'urls' => [
                'create_url' => route('computer-equipments-movements.create'),
                'restore_url' => route('computer-equipments-movements.trash'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', ComputerEquipmentMovement::class),
                'restore' => auth()->user()->can('restoreAny', ComputerEquipmentMovement::class),
            ],
            'equipmentsList' => ComputerEquipment::getEquipmentList(),
            'personalList' => array_merge($usersTech, $users),
            'statusesList' => Status::select('id', 'name')->get(),
            'departmentsList' => Department::select('id', 'name')->whereNotNull('parent_id')->get(),
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

        return Inertia::render('ComputerEquipmentMovements/Add', [
            'equipments' => ComputerEquipment::getEquipmentList(),
            'statuses' => Status::select('id', 'name')->get(),
            'users' => User::getDepartmentList(),
            'usersTech' => User::getDepartmentList($this->department_informatica),
            'departments' => Department::select('id', 'name')->whereNotNull('parent_id')->get(),
            'return_url' => route('computer-equipments-movements.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreComputerEquipmentMovementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComputerEquipmentMovementRequest $request)
    {
        $this->authorize('create', ComputerEquipmentMovement::class);

        $equipment = ComputerEquipment::find($request->input('equipment_id'));

        $data = $request->all();
        $data['previous_department_id'] = $equipment->department_id;
        $data['status_id'] = 1; // active

        $movement = ComputerEquipmentMovement::create($data);

        $equipment->update([
            'status_id' => 1,
            'department_id' => $data['current_department_id'],
        ]);

        $request->session()->flash('success', 'Trasladó de equipo creado satisfactoriamente');
        return redirect()->route('computer-equipments-movements.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function show($computerEquipmentMovement_id)
    {
        $computerEquipmentMovement = ComputerEquipmentMovement::find($computerEquipmentMovement_id);

        $this->authorize('view', $computerEquipmentMovement);

        $computerEquipmentMovement = ComputerEquipmentMovement::with(
            'previousDepartment',
            'currentDepartment',
            'userMovement',
            'userResponsible',
            'equipment',
            'status'
        )
            ->where('id', $computerEquipmentMovement->id)->first();

        $computerEquipmentMovement = [
            'id' => $computerEquipmentMovement->id,
            'previous_department' => $computerEquipmentMovement->previousDepartment->name ?? null,
            'current_department' => $computerEquipmentMovement->currentDepartment->name ?? null,
            'user_movement' => $computerEquipmentMovement->userMovement->name ?? null,
            'user_responsible' => $computerEquipmentMovement->userResponsible->name ?? null,
            'user_assigned' => $computerEquipmentMovement->user_assigned ?? null,
            'equipment' => $computerEquipmentMovement->equipment->only('id', 'description', 'code', 'serial') ?? null,
            'status' => $computerEquipmentMovement->status->name ?? null,
            'transfer_date' => $computerEquipmentMovement->transfer_date,
            'incidence' => $computerEquipmentMovement->incidence,
            'period_start' => $computerEquipmentMovement->period_start,
            'period_end' => $computerEquipmentMovement->period_end,
        ];

        return Inertia::render('ComputerEquipmentMovements/Show', [
            'return_url' => route('computer-equipments-movements.index'),
            'computerEquipmentMovement' => $computerEquipmentMovement,
        ]);
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

        $current_equipment = [
            'id' => $computerEquipmentMovement->equipment->id ?? null,
            'name' => $computerEquipmentMovement->equipment->code ?? null
        ];

        return Inertia::render('ComputerEquipmentMovements/Edit', [
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
            'equipments' => ComputerEquipment::getEquipmentList(),
            'statuses' => Status::select('id', 'name')->get(),
            'users' => User::getDepartmentList(),
            'usersTech' => User::getDepartmentList($this->department_informatica),
            'departments' => Department::select('id', 'name')->whereNotNull('parent_id')->get(),
            'return_url' => route('computer-equipments-movements.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComputerEquipmentMovementRequest  $request
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComputerEquipmentMovementRequest $request, $computerEquipmentMovement_id)
    {
        $computerEquipmentMovement = ComputerEquipmentMovement::find($computerEquipmentMovement_id);

        $this->authorize('update', $computerEquipmentMovement);

        $equipment = ComputerEquipment::find($request->input('equipment_id'));

        $data = $request->all();

        $computerEquipmentMovement->update($data);

        $equipment->update([
            'department_id' => $data['current_department_id'],
        ]);

        $request->session()->flash('success', 'Trasladó de equipo actualizado satisfactoriamente');
        return redirect()->route('computer-equipments-movements.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $computerEquipmentMovement_id)
    {
        $computerEquipmentMovement = ComputerEquipmentMovement::find($computerEquipmentMovement_id);

        $this->authorize('delete', $computerEquipmentMovement);

        $computerEquipmentMovement->delete();

        $request->session()->flash('info', 'Trasladó de equipo eliminado satisfactoriamente');
        return redirect()->route('computer-equipments-movements.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->authorize('restoreAny', ComputerEquipmentMovement::class);

        $items = ComputerEquipmentMovement::with(
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

        $usersTech = User::getDepartmentList($this->department_informatica);
        $users = User::getDepartmentList();

        return Inertia::render('ComputerEquipmentMovements/Trash', [
            'filters' => [
                'equipment_search' => $request->only('equipment_search'),
                'personal_search' => $request->only('personal_search'),
                'department_search' => $request->only('department_search'),
                'status_search' => $request->only('status_search'),
            ],
            'items' => $items,
            'urls' => [
                'return_url' => route('computer-equipments-movements.index'),
            ],
            'equipmentsList' => ComputerEquipment::getEquipmentList(),
            'personalList' => array_merge($usersTech, $users),
            'statusesList' => Status::select('id', 'name')->get(),
            'departmentsList' => Department::select('id', 'name')->whereNotNull('parent_id')->get(),
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $computerEquipmentMovement_id)
    {
        $computerEquipmentMovement = ComputerEquipmentMovement::onlyTrashed()->find($computerEquipmentMovement_id);

        $this->authorize('restore', $computerEquipmentMovement);

        $computerEquipmentMovement->restore();

        $request->session()->flash('success', 'Trasladó de equipo restaurado satisfactoriamente');
        return redirect()->route('computer-equipments-movements.trash');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function trashDestroy(Request $request, $computerEquipmentMovement_id)
    {
        $computerEquipmentMovement = ComputerEquipmentMovement::onlyTrashed()->find($computerEquipmentMovement_id);

        $this->authorize('forceDelete', $computerEquipmentMovement);

        $computerEquipmentMovement->forceDelete();

        $request->session()->flash('warn', 'Trasladó de equipo eliminado definitivamente');
        return redirect()->route('computer-equipments-movements.trash');
    }
}
