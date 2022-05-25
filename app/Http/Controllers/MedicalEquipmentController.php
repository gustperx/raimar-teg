<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalEquipment\StoreMedicalEquipmentRequest;
use App\Http\Requests\MedicalEquipment\UpdateMedicalEquipmentRequest;
use App\Models\Category;
use App\Models\MedicalEquipment;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MedicalEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', MedicalEquipment::class);

        $items = MedicalEquipment::with('category', 'status')->orderBy('id', 'desc')
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

        $categories = Category::select('id', 'name')
            ->where('parent_id', '2')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        $statuses = Status::select('id', 'name')
            ->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        return Inertia::render('MedicalEquipments/Add', [
            'categories' => $categories,
            'statuses' => $statuses,
            'return_url' => route('medical-equipments.index')
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
        $data['status_id'] = 1; // active

        MedicalEquipment::create($data);

        $request->session()->flash('success', 'Equipo medicó creado satisfactoriamente');
        return redirect()->route('medical-equipments.index');
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

        $medicalEquipment = MedicalEquipment::with('category', 'status')->where('id', $medicalEquipment->id)->first();
        $medicalEquipment = [
            'id' => $medicalEquipment->id,
            'description' => $medicalEquipment->description,
            'brand' => $medicalEquipment->brand,
            'model' => $medicalEquipment->model,
            'code' => $medicalEquipment->code,
            'serial' => $medicalEquipment->serial,
            'category' => $medicalEquipment->category->name ?? null,
            'status' => $medicalEquipment->status->name ?? null,
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

        $categories = Category::select('id', 'name')
            ->where('parent_id', '2')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        $statuses = Status::select('id', 'name')
            ->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        return Inertia::render('MedicalEquipments/Edit', [
            'medicalEquipment' => $medicalEquipment->only(
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

        $medicalEquipment->update($request->all());

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

        $request->session()->flash('info', 'Equipo medicó eliminado satisfactoriamente');
        return redirect()->route('medical-equipments.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->authorize('restoreAny', MedicalEquipment::class);

        $items = MedicalEquipment::with('category', 'status')->onlyTrashed()->orderBy('id', 'desc')
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

        $request->session()->flash('warn', 'Equipo medicó eliminado definitivamente');
        return redirect()->route('medical-equipments.trash');
    }
}
