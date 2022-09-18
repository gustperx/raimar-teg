<?php

namespace App\Http\Controllers;

use App\Models\ModelE;
use Illuminate\Http\Request;
use App\Http\Requests\Model\StoreModelERequest;
use App\Http\Requests\Model\UpdateModelERequest;

class ModelEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->query('type');

        if (empty($type)) {
            $data = ModelE::get();
        } else {
            $data = ModelE::where('type', $type)->get();
        }

        $resp = [];
        if (!empty($data)) {
            $resp = $data->map(function ($item) {
                return ['id' => $item->id, 'name' => $item->name];
            })->toArray();
        }

        return $resp;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreModelERequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModelERequest $request)
    {
        $data = $request->only('name', 'type');
        $model = ModelE::create($data);
        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModelE  $modelE
     * @return \Illuminate\Http\Response
     */
    public function show(ModelE $modelE)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModelE  $modelE
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelE $modelE)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateModelERequest  $request
     * @param  \App\Models\ModelE  $modelE
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModelERequest $request, ModelE $modelE)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModelE  $modelE
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelE $modelE)
    {
        //
    }
}
