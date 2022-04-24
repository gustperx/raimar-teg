<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComputerEquipment\StoreComputerEquipmentRequest;
use App\Http\Requests\ComputerEquipment\UpdateComputerEquipmentRequest;
use App\Models\Category;
use App\Models\ComputerEquipment;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComputerEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', ComputerEquipment::class);

        $items = ComputerEquipment::with('category', 'status')->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'description' => $item->description,
                    'brand' => $item->brand,
                    'model' => $item->model,
                    'code' => $item->code,
                    'serial' => $item->serial,
                    'category' => $item->category->name ?? null,
                    'status' => $item->status->name ?? null,
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

        $categories = Category::select('id', 'name')
            ->where('parent_id', '1')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        $statuses = Status::select('id', 'name')
            ->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        return Inertia::render('ComputerEquipments/Add', [
            'categories' => $categories,
            'statuses' => $statuses,
            'return_url' => route('computer-equipments.index')
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

        ComputerEquipment::create($request->all());

        $request->session()->flash('success', 'Equipo de cómputo creado satisfactoriamente');
        return redirect()->route('computer-equipments.index');
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

        $computerEquipment = ComputerEquipment::with('category', 'status')->where('id', $computerEquipment->id)->first();
        $computerEquipment = [
            'id' => $computerEquipment->id,
            'description' => $computerEquipment->description,
            'brand' => $computerEquipment->brand,
            'model' => $computerEquipment->model,
            'code' => $computerEquipment->code,
            'serial' => $computerEquipment->serial,
            'category' => $computerEquipment->category->name ?? null,
            'status' => $computerEquipment->status->name ?? null,
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

        $categories = Category::select('id', 'name')
            ->where('parent_id', '1')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        $statuses = Status::select('id', 'name')
            ->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        return Inertia::render('ComputerEquipments/Edit', [
            'computerEquipment' => $computerEquipment->only(
                'id',
                'description',
                'brand',
                'model',
                'code',
                'serial',
                'category_id',
                'status_id'
            ),
            'categories' => $categories,
            'statuses' => $statuses,
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

        $computerEquipment->update($request->all());

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

        $request->session()->flash('info', 'Equipo de cómputo eliminado satisfactoriamente');
        return redirect()->route('computer-equipments.index');
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
                    'brand' => $item->brand,
                    'model' => $item->model,
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

        $request->session()->flash('warn', 'Equipo de cómputo eliminado definitivamente');
        return redirect()->route('computer-equipments.trash');
    }
}
