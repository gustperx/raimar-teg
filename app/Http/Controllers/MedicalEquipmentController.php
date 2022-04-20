<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalEquipment\StoreMedicalEquipmentRequest;
use App\Http\Requests\MedicalEquipment\UpdateMedicalEquipmentRequest;
use App\Models\MedicalEquipment;

class MedicalEquipmentController extends Controller
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
     * @param  \App\Http\Requests\StoreMedicalEquipmentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMedicalEquipmentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Http\Response
     */
    public function show(MedicalEquipment $medicalEquipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Http\Response
     */
    public function edit(MedicalEquipment $medicalEquipment)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedicalEquipment $medicalEquipment)
    {
        //
    }
}
