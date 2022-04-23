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

    // Statuses
    Route::get('statuses/trash', [StatusController::class, 'trash'])->name('statuses.trash');
    Route::post('statuses/trash/restore/{status}', [StatusController::class, 'restore'])->name('statuses.trash_restore');
    Route::delete('statuses/trash/delete/{status}', [StatusController::class, 'trashDestroy'])->name('statuses.trash_destroy');
    Route::resource('statuses',   StatusController::class);

    // Categories
    Route::get('categories/trash', [CategoryController::class, 'trash'])->name('categories.trash');
    Route::post('categories/trash/restore/{category}', [CategoryController::class, 'restore'])->name('categories.trash_restore');
    Route::delete('categories/trash/delete/{category}', [CategoryController::class, 'trashDestroy'])->name('categories.trash_destroy');
    Route::resource('categories', CategoryController::class);

    // Departments
    Route::get('departments/trash', [DepartmentController::class, 'trash'])->name('departments.trash');
    Route::post('departments/trash/restore/{departmen}', [DepartmentController::class, 'restore'])->name('departments.trash_restore');
    Route::delete('departments/trash/delete/{departmen}', [DepartmentController::class, 'trashDestroy'])->name('departments.trash_destroy');
    Route::resource('departments', DepartmentController::class);

    // MedicalEquipaments
    Route::get('medical-equipments/trash', [MedicalEquipmentController::class, 'trash'])->name('medical-equipments.trash');
    Route::post('medical-equipments/trash/restore/{medical_equipment}', [MedicalEquipmentController::class, 'restore'])->name('medical-equipments.trash_restore');
    Route::delete('medical-equipments/trash/delete/{medical_equipment}', [MedicalEquipmentController::class, 'trashDestroy'])->name('medical-equipments.trash_destroy');
    Route::resource('medical-equipments',  MedicalEquipmentController::class);

    // ComputerEquipments
    Route::get('computer-equipments/trash', [ComputerEquipmentController::class, 'trash'])->name('computer-equipments.trash');
    Route::post('computer-equipments/trash/restore/{computer_equipment}', [ComputerEquipmentController::class, 'restore'])->name('computer-equipments.trash_restore');
    Route::delete('computer-equipments/trash/delete/{computer_equipment}', [ComputerEquipmentController::class, 'trashDestroy'])->name('computer-equipments.trash_destroy');
    Route::resource('computer-equipments', ComputerEquipmentController::class);

    // MedicalEquipamentMovements
    Route::resource('medical-equipments-movements',  MedicalEquipmentMovementController::class);

    // ComputerEquipmentMovements
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
