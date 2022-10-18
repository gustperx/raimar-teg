<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Status;
use App\Models\Category;
use App\Traits\Auditable;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\MedicalEquipment;
use Illuminate\Support\Facades\DB;
use App\Models\MedicalEquipmentMovement;
use App\Http\Requests\MedicalEquipment\StoreMedicalEquipmentRequest;
use App\Http\Requests\MedicalEquipment\UpdateMedicalEquipmentRequest;

class MedicalEquipmentController extends Controller
{
    use Auditable;
    private $module = 'Equipos médicos';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', MedicalEquipment::class);

        $items = MedicalEquipment::with('category', 'status', 'department')->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'brand' => $item->brand->name ?? null,
                    'model' => $item->model->name ?? null,
                    'code' => $item->code,
                    'serial' => $item->serial,
                    'category' => $item->category->name ?? null,
                    'status' => $item->status->name ?? null,
                    'status_color' => $item->status->color ?? null,
                    'department' => $item->department->name ?? null,
                    'updated_at' => $item->updated_at->format('d/m/Y H:i'),
                    'edit_url' => route('medical-equipments.edit', $item),
                    'show_url' => route('medical-equipments.show', $item),
                    'can' => [
                        'show' => auth()->user()->can('view', $item),
                        'edit' => auth()->user()->can('update', $item),
                        'delete' => auth()->user()->can('delete', $item),
                    ]
                ];
            });

        return Inertia::render('MedicalEquipments/Index', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'create_url' => route('medical-equipments.create'),
                'restore_url' => route('medical-equipments.trash'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', MedicalEquipment::class),
                'restore' => auth()->user()->can('restoreAny', MedicalEquipment::class),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', MedicalEquipment::class);

        $categories = Category::select('id', 'name')->where('parent_id', '2')->get();
        $statuses = Status::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->whereIn('id', [19, 33])->get();

        return Inertia::render('MedicalEquipments/Add', [
            'categories' => $categories,
            'statuses' => $statuses,
            'departments' => $departments,
            'return_url' => route('d_register') // route('medical-equipments.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMedicalEquipmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicalEquipmentRequest $request)
    {
        $this->authorize('create', MedicalEquipment::class);

        $data = $request->all();
        $data['brand_id'] = $data['brand'];
        $data['model_id'] = $data['model'];
        $data['status_id'] = 1; // active

        $equipment = MedicalEquipment::create($data);

        $this->audit(
            $this->module,
            'Creación nuevo equipo: ' . $equipment->code
        );

        $request->session()->flash('success', 'Equipo medicó creado satisfactoriamente');
        // return redirect()->route('medical-equipments.index');
        return redirect()->route('d_register');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalEquipment $medicalEquipment)
    {
        $this->authorize('view', $medicalEquipment);

        $medicalEquipment = MedicalEquipment::with('category', 'status', 'department')->where('id', $medicalEquipment->id)->first();
        $medicalEquipment = [
            'id' => $medicalEquipment->id,
            'description' => $medicalEquipment->description,
            'brand' => $medicalEquipment->brand->name ?? null,
            'model' => $medicalEquipment->model->name ?? null,
            'code' => $medicalEquipment->code,
            'serial' => $medicalEquipment->serial,
            'category' => $medicalEquipment->category->name ?? null,
            'status' => $medicalEquipment->status->name ?? null,
            'department' => $medicalEquipment->department->name ?? null,
        ];

        return Inertia::render('MedicalEquipments/Show', [
            'return_url' => route('medical-equipments.index'),
            'medicalEquipment' => $medicalEquipment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalEquipment $medicalEquipment)
    {
        $this->authorize('update', $medicalEquipment);

        $categories = Category::select('id', 'name')->where('parent_id', '2')->get();
        $statuses = Status::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->whereIn('id', [19, 33])->get();

        return Inertia::render('MedicalEquipments/Edit', [
            'medicalEquipment' => $medicalEquipment->only(
                'id',
                'description',
                'brand',
                'model',
                'code',
                'serial',
                'category_id',
                'status_id',
                'department_id'
            ),
            'categories' => $categories,
            'statuses' => $statuses,
            'departments' => $departments,
            'return_url' => route('medical-equipments.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMedicalEquipmentRequest  $request
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMedicalEquipmentRequest $request, MedicalEquipment $medicalEquipment)
    {
        $this->authorize('update', $medicalEquipment);

        $data = $request->all();
        $data['brand_id'] = $data['brand'];
        $data['model_id'] = $data['model'];

        $medicalEquipment->update($data);

        $this->audit(
            $this->module,
            'Actualización de equipo: ' . $medicalEquipment->code
        );

        $request->session()->flash('success', 'Equipo medicó actualizado satisfactoriamente');
        return redirect()->route('medical-equipments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, MedicalEquipment $medicalEquipment)
    {
        $this->authorize('delete', $medicalEquipment);

        $medicalEquipment->delete();

        $this->audit(
            $this->module,
            'Eliminación suave de equipo: ' . $medicalEquipment->code
        );

        $request->session()->flash('info', 'Equipo medicó eliminado satisfactoriamente');
        return redirect()->route('medical-equipments.index');
    }


    public function available(Request $request)
    {
        $items = MedicalEquipment::with('category', 'status', 'department', 'movements')
            ->where('status_id', 1) // Operativo
            ->doesntHave('movements')
            ->orderBy('id', 'desc')
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'brand' => $item->brand->name ?? null,
                    'model' => $item->model->name ?? null,
                    'code' => $item->code,
                    'serial' => $item->serial,
                    'category' => $item->category->name ?? null,
                    'status' => $item->status->name ?? null,
                    'status_color' => $item->status->color ?? null,
                    'department' => $item->department->name ?? null,
                    'updated_at' => $item->updated_at->format('d/m/Y H:i'),
                    'apply_name' => Order::where('type', 'medical')->where('equipment_id', $item->id)->first()->user->name ?? null,
                    'apply_url' => route('medical-equipments.apply', $item),
                    'approve_url' => route('medical-equipments.approve_show', $item),
                    'can' => [
                        'apply' => Order::where('type', 'medical')->where('equipment_id', $item->id)->count() == 0,
                        'approve' => auth()->user()->can('create', MedicalEquipmentMovement::class) && Order::where('type', 'medical')->where('equipment_id', $item->id)->count() > 0,
                    ]
                ];
            });

        return Inertia::render('MedicalEquipments/Orders', [
            'items' => $items,
        ]);
    }


    public function apply(Request $request, MedicalEquipment $medicalEquipment)
    {
        Order::create([
            'user_id' => auth()->user()->id,
            'type' => 'medical',
            'equipment_id' => $medicalEquipment->id,
        ]);

        $this->audit(
            $this->module,
            'Aplicar solicitud de equipo: ' . $medicalEquipment->code
        );

        $request->session()->flash('success', 'Pedido de equipo realizado');

        return back();
    }


    public function approveShow(Request $request, MedicalEquipment $medicalEquipment)
    {
        $order = Order::with('equipment', 'user.department')
            ->where('type', 'medical')
            ->where('equipment_id', $medicalEquipment->id)->first();

        $equipment = [
            'id' => $order->equipment->id,
            'description' => $order->equipment->description,
            'brand' => $order->equipment->brand->name ?? null,
            'model' => $order->equipment->model->name ?? null,
            'code' => $order->equipment->code,
            'serial' => $order->equipment->serial,
            'category' => $order->equipment->category->name ?? null,
            'status' => $order->equipment->status->name ?? null,
            'department' => $order->equipment->department->name ?? null,
        ];

        $user = [
            'id' => $order->user->id,
            'name' => $order->user->name,
            'email' => $order->user->email,
            'dni' => $order->user->dni,
            'dni_type' => $order->user->dni_type ?? null,
            'department' => $order->user->department->name ?? null,
        ];

        return Inertia::render('MedicalEquipments/OrderShow', [
            'equipment' => $equipment,
            'user' => $user,
            'return_url' => route('medical-equipments.available'),
            'approve_url' => route('medical-equipments.approve', $medicalEquipment->id),
            'decline_url' => route('medical-equipments.decline', $medicalEquipment->id)
        ]);
    }


    public function approve(Request $request, MedicalEquipment $medicalEquipment)
    {
        DB::beginTransaction();
        try {
            $order = Order::with('equipment', 'user.department')
                ->where('type', 'medical')
                ->where('equipment_id', $medicalEquipment->id)->first();

            $data = [
                'current_department_id' => $order->user->department_id,
                'previous_department_id' => $medicalEquipment->department_id,
                'user_movement_id' => auth()->user()->id,
                'user_responsible_id' => $order->user->id,
                'user_assigned_id' => $order->user->id,
                'equipment_id' => $order->equipment->id,
                'transfer_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'status_id' => 1,
                'incidence' => 'aprobacion de solicitud de equipo'
            ];

            $movement = MedicalEquipmentMovement::create($data);

            $medicalEquipment->update([
                'status_id' => 1,
                'department_id' => $order->user->department_id,
            ]);

            $this->audit(
                $this->module,
                'Aprobar solicitud de equipo: ' . $medicalEquipment->code
            );

            DB::commit();

            $request->session()->flash('success', 'Trasladó de equipo creado satisfactoriamente');
            return redirect()->route('medical-equipments-movements.index');

        } catch (\Exception $e) {

            DB::rollBack();

            $request->session()->flash('error', $e->getMessage());
            return back();
        }
    }


    public function decline(Request $request, MedicalEquipment $medicalEquipment)
    {
        $order = Order::where('type', 'medical')->where('equipment_id', $medicalEquipment->id)->first();

        if (!empty($order)) {
            $order->delete();
        }

        $this->audit(
            $this->module,
            'Rechazar solicitud de equipo: ' . $medicalEquipment->code
        );

        $request->session()->flash('info', 'Solicitud de pedido de equipo rechazada');
        return redirect()->route('medical-equipments.available');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->authorize('restoreAny', MedicalEquipment::class);

        $items = MedicalEquipment::with('category', 'status', 'department')->onlyTrashed()->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'brand' => $item->brand->name ?? null,
                    'model' => $item->model->name ?? null,
                    'code' => $item->code,
                    'serial' => $item->serial,
                    'category' => $item->category->name ?? null,
                    'status' => $item->status->name ?? null,
                    'can' => [
                        'restore' => auth()->user()->can('restore', $item),
                        'forceDelete' => auth()->user()->can('forceDelete', $item),
                    ]
                ];
            });

        return Inertia::render('MedicalEquipments/Trash', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'return_url' => route('medical-equipments.index'),
            ]
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $medicalEquipment_id)
    {
        $medicalEquipment = MedicalEquipment::onlyTrashed()->find($medicalEquipment_id);

        $this->authorize('restore', $medicalEquipment);

        $medicalEquipment->restore();

        $this->audit(
            $this->module,
            'Recuperación de equipo: ' . $medicalEquipment->code
        );

        $request->session()->flash('success', 'Equipo medicó restaurado satisfactoriamente');
        return redirect()->route('medical-equipments.trash');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Http\Response
     */
    public function trashDestroy(Request $request, $medicalEquipment_id)
    {
        $medicalEquipment = MedicalEquipment::onlyTrashed()->find($medicalEquipment_id);

        $this->authorize('forceDelete', $medicalEquipment);

        $medicalEquipment->forceDelete();

        $this->audit(
            $this->module,
            'Eliminación fuerte de equipo: ' . $medicalEquipment->code
        );

        $request->session()->flash('warn', 'Equipo medicó eliminado definitivamente');
        return redirect()->route('medical-equipments.trash');
    }
}
