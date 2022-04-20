<?php

use App\Http\Controllers\StatusController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MedicalEquipmentController;
use App\Http\Controllers\ComputerEquipmentController;
use App\Http\Controllers\MedicalEquipmentMovementController;
use App\Http\Controllers\ComputerEquipmentMovementController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    Route::resource('statuses',   StatusController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('departmens', DepartmentController::class);
    Route::resource('medical-equipments',  MedicalEquipmentController::class);
    Route::resource('computer-equipments', ComputerEquipmentController::class);
    Route::resource('medical-equipments-movements',  MedicalEquipmentMovementController::class);
    Route::resource('computer-equipments-movements', ComputerEquipmentMovementController::class);
});

/* Route::get('test', function () {

    $permissions = collect(config('permission_rules'));

    $final = [];
    foreach ($permissions as $key => $permission) {
        $collect = collect($permission);
        $plucked = $collect->pluck('permission', 'display_name');
        $final[$key] = $plucked->all();
    }

    $collect = collect($final);

    dd($final, $collect->flatten()->toArray());
}); */
