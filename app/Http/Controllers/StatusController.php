<?php

namespace App\Http\Controllers;

use App\Http\Requests\Status\StoreStatusRequest;
use App\Http\Requests\Status\UpdateStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Status::class);

        $items = Status::orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate(10)->through(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'edit_url' => route('statuses.edit', $item),
                    'show_url' => route('statuses.show', $item),
                    'can' => [
                        'show' => auth()->user()->can('view', $item),
                        'edit' => auth()->user()->can('update', $item),
                        'delete' => auth()->user()->can('delete', $item),
                    ]
                ];
            });

        return Inertia::render('Statuses/Index', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'create_url' => route('statuses.create'),
                'restore_url' => route('statuses.trash'),
            ],
            'can' => [
                'create' => auth()->user()->can('create', Status::class),
                'restore' => auth()->user()->can('restoreAny', Status::class),
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
        $this->authorize('create', Status::class);

        return Inertia::render('Statuses/Add', [
            'return_url' => route('statuses.index')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreStatusRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStatusRequest $request)
    {
        $this->authorize('create', Status::class);

        Status::create($request->all());

        $request->session()->flash('success', 'Estado creado satisfactoriamente');
        return redirect()->route('statuses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function show(Status $status)
    {
        $this->authorize('view', $status);

        return Inertia::render('Statuses/Show', [
            'return_url' => route('statuses.index'),
            'status' => $status->only('id', 'name')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function edit(Status $status)
    {
        $this->authorize('update', $status);

        return Inertia::render('Statuses/Edit', [
            'return_url' => route('statuses.index'),
            'status' => $status->only('id', 'name')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateStatusRequest  $request
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStatusRequest $request, Status $status)
    {
        $this->authorize('update', $status);

        $status->update($request->all());

        $request->session()->flash('success', 'Estado actualizado satisfactoriamente');
        return redirect()->route('statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Status $status)
    {
        $this->authorize('delete', $status);

        $status->delete();

        $request->session()->flash('info', 'Estado eliminado satisfactoriamente');
        return redirect()->route('statuses.index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Request $request)
    {
        $this->authorize('restoreAny', Status::class);

        $items = Status::onlyTrashed()->orderBy('id', 'desc')
            ->filter($request->only('search'))
            ->paginate(10)->through(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'can' => [
                        'restore' => auth()->user()->can('restore', $item),
                        'forceDelete' => auth()->user()->can('forceDelete', $item),
                    ]
                ];
            });

        return Inertia::render('Statuses/Trash', [
            'filters' => $request->all('search'),
            'items' => $items,
            'urls' => [
                'return_url' => route('statuses.index'),
            ]
        ]);
    }


    /**
     * Restore the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function restore(Request $request, $status_id)
    {
        $status = Status::onlyTrashed()->find($status_id);

        $this->authorize('restore', $status);

        $status->restore();

        $request->session()->flash('success', 'Estado restaurado definitivamente');
        return redirect()->route('statuses.trash');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function trashDestroy(Request $request, $status_id)
    {
        $status = Status::onlyTrashed()->find($status_id);

        $this->authorize('forceDelete', $status);

        $status->forceDelete();

        $request->session()->flash('warn', 'Estado eliminado definitivamente');
        return redirect()->route('statuses.trash');
    }
}
