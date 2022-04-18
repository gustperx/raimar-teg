<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComputerEquipmentRequest;
use App\Http\Requests\UpdateComputerEquipmentRequest;
use App\Models\ComputerEquipment;

class ComputerEquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreComputerEquipmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComputerEquipmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Http\Response
     */
    public function show(ComputerEquipment $computerEquipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Http\Response
     */
    public function edit(ComputerEquipment $computerEquipment)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComputerEquipment $computerEquipment)
    {
        //
    }
}
