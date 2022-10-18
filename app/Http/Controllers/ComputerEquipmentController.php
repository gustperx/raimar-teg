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
use App\Models\ComputerEquipment;
use Illuminate\Support\Facades\DB;
use App\Models\ComputerEquipmentMovement;
use App\Http\Requests\ComputerEquipment\StoreComputerEquipmentRequest;
use App\Http\Requests\ComputerEquipment\UpdateComputerEquipmentRequest;

class ComputerEquipmentController extends Controller
{
    use Auditable;
    private $module = 'Equipos de cómputo';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ComputerEquipment::class);

        $items = ComputerEquipment::with('category', 'status', 'department')->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'brand' => $item->brand->name ?? null,
                    'model' => $item->model->name ?? null,
                    'code' => $item->code,
                    'serial' => $item->serial,
                    'updated_at' => $item->updated_at->format('d/m/Y H:i'),
                    'category' => $item->category->name ?? null,
                    'status' => $item->status->name ?? null,
                    'status_color' => $item->status->color ?? null,
                    'department' => $item->department->name ?? null,
                    'edit_url' => route('computer-equipments.edit', $item),
                    'show_url' => route('computer-equipments.show', $item),
                    'can' => [
                        'show' => auth()->user()->can('view', $item),
                        'edit' => auth()->user()->can('update', $item),
                        'delete' => auth()->user()->can('delete', $item),
                    ]
                ];
            });

        return Inertia::render('ComputerEquipments/Index', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'create_url' => route('computer-equipments.create'),
                'restore_url' => route('computer-equipments.trash'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', ComputerEquipment::class),
                'restore' => auth()->user()->can('restoreAny', ComputerEquipment::class),
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
        $this->authorize('create', ComputerEquipment::class);

        $categories = Category::select('id', 'name')->where('parent_id', 1)->get();
        $statuses = Status::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->where('id', 4)->get();

        return Inertia::render('ComputerEquipments/Add', [
            'categories' => $categories,
            'statuses' => $statuses,
            'departments' => $departments,
            'return_url' => route('d_register') // route('computer-equipments.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreComputerEquipmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComputerEquipmentRequest $request)
    {
        $this->authorize('create', ComputerEquipment::class);

        $data = $request->all();
        $data['brand_id'] = $data['brand'];
        $data['model_id'] = $data['model'];
        $data['status_id'] = 1; // active

        $equipment = ComputerEquipment::create($data);

        $this->audit(
            $this->module,
            'Creación nuevo equipo: ' . $equipment->id
        );

        $request->session()->flash('success', 'Equipo de cómputo creado satisfactoriamente');
        // return redirect()->route('computer-equipments.index');
        return redirect()->route('d_register');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Http\Response
     */
    public function show(ComputerEquipment $computerEquipment)
    {
        $this->authorize('view', $computerEquipment);

        $computerEquipment = ComputerEquipment::with('category', 'status', 'department')->where('id', $computerEquipment->id)->first();
        $computerEquipment = [
            'id' => $computerEquipment->id,
            'description' => $computerEquipment->description,
            'brand' => $computerEquipment->brand->name ?? null,
            'model' => $computerEquipment->model->name ?? null,
            'code' => $computerEquipment->code,
            'serial' => $computerEquipment->serial,
            'category' => $computerEquipment->category->name ?? null,
            'status' => $computerEquipment->status->name ?? null,
            'department' => $computerEquipment->department->name ?? null,
        ];

        return Inertia::render('ComputerEquipments/Show', [
            'return_url' => route('computer-equipments.index'),
            'computerEquipment' => $computerEquipment,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Http\Response
     */
    public function edit(ComputerEquipment $computerEquipment)
    {
        $this->authorize('update', $computerEquipment);

        $categories = Category::select('id', 'name')->where('parent_id', 1)->get();
        $statuses = Status::select('id', 'name')->get();
        $departments = Department::select('id', 'name')->where('id', 4)->get();

        return Inertia::render('ComputerEquipments/Edit', [
            'computerEquipment' => $computerEquipment->only(
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
            'return_url' => route('computer-equipments.index')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComputerEquipmentRequest  $request
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComputerEquipmentRequest $request, ComputerEquipment $computerEquipment)
    {
        $this->authorize('update', $computerEquipment);

        $data = $request->all();
        $data['brand_id'] = $data['brand'];
        $data['model_id'] = $data['model'];

        $computerEquipment->update($data);

        $this->audit(
            $this->module,
            'Actualización de equipo: ' . $computerEquipment->id
        );

        $request->session()->flash('success', 'Equipo de cómputo actualizado satisfactoriamente');
        return redirect()->route('computer-equipments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ComputerEquipment $computerEquipment)
    {
        $this->authorize('delete', $computerEquipment);

        $computerEquipment->delete();

        $this->audit(
            $this->module,
            'Eliminación suave de equipo: ' . $computerEquipment->id
        );

        $request->session()->flash('info', 'Equipo de cómputo eliminado satisfactoriamente');
        return redirect()->route('computer-equipments.index');
    }


    public function available(Request $request)
    {
        $items = ComputerEquipment::with('category', 'status', 'department', 'movements')
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
                    'updated_at' => $item->updated_at->format('d/m/Y H:i'),
                    'category' => $item->category->name ?? null,
                    'status' => $item->status->name ?? null,
                    'status_color' => $item->status->color ?? null,
                    'department' => $item->department->name ?? null,
                    'apply_name' => Order::where('type', 'informatica')->where('equipment_id', $item->id)->first()->user->name ?? null,
                    'apply_url' => route('computer-equipments.apply', $item),
                    'approve_url' => route('computer-equipments.approve_show', $item),
                    'can' => [
                        'apply' => Order::where('type', 'informatica')->where('equipment_id', $item->id)->count() == 0,
                        'approve' => auth()->user()->can('create', ComputerEquipmentMovement::class) && Order::where('type', 'informatica')->where('equipment_id', $item->id)->count() > 0,
                    ]
                ];
            });

        return Inertia::render('ComputerEquipments/Orders', [
            'items' => $items,
        ]);
    }


    public function apply(Request $request, ComputerEquipment $computerEquipment)
    {
        Order::create([
            'user_id' => auth()->user()->id,
            'type' => 'informatica',
            'equipment_id' => $computerEquipment->id,
        ]);

        $this->audit(
            $this->module,
            'Aplicar solicitud de equipo: ' . $computerEquipment->id
        );

        $request->session()->flash('success', 'Pedido de equipo realizado');

        return back();
    }


    public function approveShow(Request $request, ComputerEquipment $computerEquipment)
    {
        $order = Order::with('equipment', 'user.department')
            ->where('type', 'informatica')
            ->where('equipment_id', $computerEquipment->id)->first();

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

        return Inertia::render('ComputerEquipments/OrderShow', [
            'equipment' => $equipment,
            'user' => $user,
            'return_url' => route('computer-equipments.available'),
            'approve_url' => route('computer-equipments.approve', $computerEquipment->id),
            'decline_url' => route('computer-equipments.decline', $computerEquipment->id)
        ]);
    }


    public function approve(Request $request, ComputerEquipment $computerEquipment)
    {
        DB::beginTransaction();
        try {
            $order = Order::with('equipment', 'user.department')
                ->where('type', 'informatica')
                ->where('equipment_id', $computerEquipment->id)->first();

            $data = [
                'current_department_id' => $order->user->department_id,
                'previous_department_id' => $computerEquipment->department_id,
                'user_movement_id' => auth()->user()->id,
                'user_responsible_id' => $order->user->id,
                'user_assigned_id' => $order->user->id,
                'equipment_id' => $order->equipment->id,
                'transfer_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'status_id' => 1,
                'incidence' => 'aprobacion de solicitud de equipo'
            ];

            $movement = ComputerEquipmentMovement::create($data);

            $computerEquipment->update([
                'status_id' => 1,
                'department_id' => $order->user->department_id,
            ]);

            $this->audit(
                $this->module,
                'Aprobar solicitud de equipo: ' . $computerEquipment->id
            );

            DB::commit();

            $request->session()->flash('success', 'Trasladó de equipo creado satisfactoriamente');
            return redirect()->route('computer-equipments-movements.index');

        } catch (\Exception $e) {

            DB::rollBack();

            $request->session()->flash('error', $e->getMessage());
            return back();
        }
    }


    public function decline(Request $request, ComputerEquipment $computerEquipment)
    {
        $order = Order::where('type', 'informatica')->where('equipment_id', $computerEquipment->id)->first();

        if (!empty($order)) {
            $order->delete();
        }

        $this->audit(
            $this->module,
            'Rechazar solicitud de equipo: ' . $computerEquipment->id
        );

        $request->session()->flash('info', 'Solicitud de pedido de equipo rechazada');
        return redirect()->route('computer-equipments.available');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->authorize('restoreAny', ComputerEquipment::class);

        $items = ComputerEquipment::with('category', 'status')->onlyTrashed()->orderBy('id', 'desc')
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

        return Inertia::render('ComputerEquipments/Trash', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'return_url' => route('computer-equipments.index'),
            ]
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $computerEquipment_id)
    {
        $computerEquipment = ComputerEquipment::onlyTrashed()->find($computerEquipment_id);

        $this->authorize('restore', $computerEquipment);

        $computerEquipment->restore();

        $this->audit(
            $this->module,
            'Recuperación de equipo: ' . $computerEquipment->id
        );

        $request->session()->flash('success', 'Equipo de cómputo restaurado satisfactoriamente');
        return redirect()->route('computer-equipments.trash');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Http\Response
     */
    public function trashDestroy(Request $request, $computerEquipment_id)
    {
        $computerEquipment = ComputerEquipment::onlyTrashed()->find($computerEquipment_id);

        $this->authorize('forceDelete', $computerEquipment);

        $computerEquipment->forceDelete();

        $this->audit(
            $this->module,
            'Eliminación fuerte de equipo: ' . $computerEquipment->id
        );

        $request->session()->flash('warn', 'Equipo de cómputo eliminado definitivamente');
        return redirect()->route('computer-equipments.trash');
    }
}
