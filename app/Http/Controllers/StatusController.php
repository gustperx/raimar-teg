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
        return Inertia::render('Statuses/Index', [
            'filters' => $request->all('search'),
            'statuses' => Status::orderBy('id', 'desc')
                ->filter($request->only('search'))
                //->paginate()
                //->withQueryString()
                ->paginate()->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'edit_url' => route('statuses.edit', $item),
                        'can' => [
                            'show' => auth()->user()->can('view', $item),
                            'edit' => auth()->user()->can('update', $item),
                            'delete' => auth()->user()->can('delete', $item),
                        ]
                    ];
                }),
            'create_url' => route('statuses.create'),
            'can' => [
                'create' => auth()->user()->can('create', Status::class),
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

        $request->session()->flash('success', 'Estado creado satisfactoriamente!');
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
        //
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
            'status' => $status
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

        $request->session()->flash('success', 'Estado actualizado satisfactoriamente!');
        return redirect()->route('statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Status  $status
     * @return \Illuminate\Http\Response
     */
    public function destroy(Status $status)
    {
        //
    }
}
