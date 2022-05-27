<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Category::class);

        $items = Category::with('parent', 'computerEquipments' , 'medicalEquipments')->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate()->through(function ($item) {

                $amount = 0;
                if (!empty($item->parent_id)) {
                    switch ($item->parent_id) {
                        case 1:
                            $amount = empty($item->computerEquipments) ? 0 : count($item->computerEquipments);
                            break;
                        case 2:
                            $amount = empty($item->medicalEquipments) ? 0 : count($item->medicalEquipments);
                            break;
                        default:
                            $amount = 0;
                            break;
                    }
                }

                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'amount' => $amount,
                    'principal' => $item->parent->name ?? null,
                    'edit_url' => route('categories.edit', $item),
                    'show_url' => route('categories.show', $item),
                    'can' => [
                        'show' => auth()->user()->can('view', $item),
                        'edit' => auth()->user()->can('update', $item),
                        'delete' => auth()->user()->can('delete', $item),
                    ]
                ];
            });

        return Inertia::render('Categories/Index', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'create_url' => route('categories.create'),
                'restore_url' => route('categories.trash'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', Category::class),
                'restore' => auth()->user()->can('restoreAny', Category::class),
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
        $this->authorize('create', Category::class);

        $principals = Category::select('id', 'name')
            ->where('id', '<=', '2')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        return Inertia::render('Categories/Add', [
            'principals' => $principals,
            'return_url' => route('categories.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->authorize('create', Category::class);

        Category::create($request->all());

        $request->session()->flash('success', 'Categoría creada satisfactoriamente');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $this->authorize('view', $category);

        $category = Category::with('parent', 'computerEquipments', 'medicalEquipments')->where('id', $category->id)->first();
        if (!empty($category->parent_id)) {
            switch ($category->parent_id) {
                case 1:
                    $equipments = $category->computerEquipments()->with('status', 'department')->get()->toArray();
                    break;
                case 2:
                    $equipments = $category->medicalEquipments()->with('status', 'department')->get()->toArray();
                    break;
                default:
                    $equipments = [];
                    break;
            }
        }

        $category = [
            'id' => $category->id,
            'name' => $category->name,
            'principal' => $category->parent->name ?? null
        ];

        return Inertia::render('Categories/Show', [
            'return_url' => route('categories.index'),
            'category' => $category,
            'equipments' => $equipments,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        $principals = Category::select('id', 'name')
            ->where('id', '<=', '2')->get()
            ->map(function ($item) {
                return ['value' => $item->id, 'label' => $item->name];
            })->toArray();

        return Inertia::render('Categories/Edit', [
            'return_url' => route('categories.index'),
            'category' => $category->only('id', 'name', 'parent_id'),
            'principals' => $principals,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);

        $category->update($request->all());

        $request->session()->flash('success', 'Categoría actualizada satisfactoriamente');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        $request->session()->flash('info', 'Categoría eliminada satisfactoriamente');
        return redirect()->route('categories.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->authorize('restoreAny', Category::class);

        $items = Category::with('parent')->onlyTrashed()->orderBy('id', 'desc')
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

        return Inertia::render('Categories/Trash', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'return_url' => route('categories.index'),
            ]
        ]);
    }


    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $category_id)
    {
        $category = Category::onlyTrashed()->find($category_id);

        $this->authorize('restore', $category);

        $category->restore();

        $request->session()->flash('success', 'Categoría restaurada satisfactoriamente');
        return redirect()->route('categories.trash');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function trashDestroy(Request $request, $category_id)
    {
        $category = Category::onlyTrashed()->find($category_id);

        $this->authorize('forceDelete', $category);

        $category->forceDelete();

        $request->session()->flash('warn', 'Categoría eliminada definitivamente');
        return redirect()->route('categories.trash');
    }
}
