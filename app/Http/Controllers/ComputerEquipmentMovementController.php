<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComputerEquipmentMovement\StoreComputerEquipmentMovementRequest;
use App\Http\Requests\ComputerEquipmentMovement\UpdateComputerEquipmentMovementRequest;
use App\Models\ComputerEquipmentMovement;

class ComputerEquipmentMovementController extends Controller
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
     * @param  \App\Http\Requests\StoreComputerEquipmentMovementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComputerEquipmentMovementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function show(ComputerEquipmentMovement $computerEquipmentMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function edit(ComputerEquipmentMovement $computerEquipmentMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateComputerEquipmentMovementRequest  $request
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateComputerEquipmentMovementRequest $request, ComputerEquipmentMovement $computerEquipmentMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ComputerEquipmentMovement  $computerEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComputerEquipmentMovement $computerEquipmentMovement)
    {
        //
    }
}
