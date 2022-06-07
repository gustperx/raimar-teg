<?php

namespace App\Http\Controllers;

use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Department::class);

        $items = Department::with('parent')->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'updated_at' => $item->updated_at->format('d/m/Y H:i'),
                    'principal' => $item->parent->name ?? null,
                    'edit_url' => route('departments.edit', $item),
                    'show_url' => route('departments.show', $item),
                    'can' => [
                        'show' => auth()->user()->can('view', $item),
                        'edit' => auth()->user()->can('update', $item),
                        'delete' => auth()->user()->can('delete', $item),
                    ]
                ];
            });

        return Inertia::render('Departments/Index', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'create_url' => route('departments.create'),
                'restore_url' => route('departments.trash'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', Department::class),
                'restore' => auth()->user()->can('restoreAny', Department::class),
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
        $this->authorize('create', Department::class);

        $principals = Department::select('id', 'name')
            ->where('id', '<=', '2')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        return Inertia::render('Departments/Add', [
            'principals' => $principals,
            'return_url' => route('departments.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDepartmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDepartmentRequest $request)
    {
        $this->authorize('create', Department::class);

        Department::create($request->all());

        $request->session()->flash('success', 'Departamento creado satisfactoriamente');
        return redirect()->route('departments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $this->authorize('view', $department);

        $department = Department::with('parent')->where('id', $department->id)->first();
        $department = [
            'id' => $department->id,
            'name' => $department->name,
            'principal' => $department->parent->name ?? null
        ];

        return Inertia::render('Departments/Show', [
            'return_url' => route('departments.index'),
            'department' => $department,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $this->authorize('update', $department);

        $principals = Department::select('id', 'name')
            ->where('id', '<=', '2')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        return Inertia::render('Departments/Edit', [
            'return_url' => route('departments.index'),
            'department' => $department->only('id', 'name', 'parent_id'),
            'principals' => $principals,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDepartmentRequest  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->authorize('update', $department);

        $department->update($request->all());

        $request->session()->flash('success', 'Departamento actualizado satisfactoriamente');
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Department $department)
    {
        $this->authorize('delete', $department);

        $department->delete();

        $request->session()->flash('info', 'Departamento eliminado satisfactoriamente');
        return redirect()->route('departments.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->authorize('restoreAny', Department::class);

        $items = Department::with('parent')->onlyTrashed()->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate()->through(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'principal' => $item->parent->name ?? null,
                    'can' => [
                        'restore' => auth()->user()->can('restore', $item),
                        'forceDelete' => auth()->user()->can('forceDelete', $item),
                    ]
                ];
            });

        return Inertia::render('Departments/Trash', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'return_url' => route('departments.index'),
            ]
        ]);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $department_id)
    {
        $department = Department::onlyTrashed()->find($department_id);

        $this->authorize('restore', $department);

        $department->restore();

        $request->session()->flash('success', 'Departamento restaurado satisfactoriamente');
        return redirect()->route('departments.trash');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function trashDestroy(Request $request, $department_id)
    {
        $department = Department::onlyTrashed()->find($department_id);

        $this->authorize('forceDelete', $department);

        $department->forceDelete();

        $request->session()->flash('warn', 'Departamento eliminado definitivamente');
        return redirect()->route('departments.trash');
    }
}
