<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalEquipmentMovement\StoreMedicalEquipmentMovementRequest;
use App\Http\Requests\MedicalEquipmentMovement\UpdateMedicalEquipmentMovementRequest;
use App\Models\MedicalEquipmentMovement;

class MedicalEquipmentMovementController extends Controller
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
     * @param  \App\Http\Requests\StoreMedicalEquipmentMovementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicalEquipmentMovementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalEquipmentMovement $medicalEquipmentMovement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalEquipmentMovement $medicalEquipmentMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMedicalEquipmentMovementRequest  $request
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMedicalEquipmentMovementRequest $request, MedicalEquipmentMovement $medicalEquipmentMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalEquipmentMovement $medicalEquipmentMovement)
    {
        //
    }
}
