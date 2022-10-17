<?php

use App\Http\Controllers\StatusController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MedicalEquipmentController;
use App\Http\Controllers\ComputerEquipmentController;
use App\Http\Controllers\MedicalEquipmentMovementController;
use App\Http\Controllers\ComputerEquipmentMovementController;
use App\Http\Controllers\MedicalMaintenanceController;
use App\Http\Controllers\ComputerMaintenanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StatsController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ModelEController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/register', [DashboardController::class, 'register'])->name('d_register');
    Route::get('/dashboard/status', [DashboardController::class, 'status'])->name('d_status');
    Route::get('/dashboard/informatica', [DashboardController::class, 'informatica'])->name('d_informatica');
    Route::get('/dashboard/operations', [DashboardController::class, 'operations'])->name('d_operations');
    Route::get('/dashboard/roles', [DashboardController::class, 'roles'])->name('d_roles');
    Route::get('/dashboard/available', [DashboardController::class, 'available'])->name('d_available');

    // Users
    // Trash
    Route::get('users/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::post('users/trash/restore/{user}', [UserController::class, 'restore'])->name('users.trash_restore');
    Route::delete('users/trash/delete/{user}', [UserController::class, 'trashDestroy'])->name('users.trash_destroy');
    // Permission
    Route::get('users/permission/{user}', [UserController::class, 'permission'])->name('users.permission');
    Route::post('users/permisssion/store/{user}', [UserController::class, 'permissionStore'])->name('users.permission_store');
    // Regular
    Route::resource('users',   UserController::class);

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
    // Available - Request
    Route::get('medical-equipments/available', [MedicalEquipmentController::class, 'available'])->name('medical-equipments.available');
    Route::get('medical-equipments/apply/{medical_equipment}', [MedicalEquipmentController::class, 'apply'])->name('medical-equipments.apply');
    Route::get('medical-equipments/approve-show/{medical_equipment}', [MedicalEquipmentController::class, 'approveShow'])->name('medical-equipments.approve_show');
    Route::get('medical-equipments/approve/{medical_equipment}', [MedicalEquipmentController::class, 'approve'])->name('medical-equipments.approve');
    Route::get('medical-equipments/decline/{medical_equipment}', [MedicalEquipmentController::class, 'decline'])->name('medical-equipments.decline');
    // Trash - Restore
    Route::get('medical-equipments/trash', [MedicalEquipmentController::class, 'trash'])->name('medical-equipments.trash');
    Route::post('medical-equipments/trash/restore/{medical_equipment}', [MedicalEquipmentController::class, 'restore'])->name('medical-equipments.trash_restore');
    Route::delete('medical-equipments/trash/delete/{medical_equipment}', [MedicalEquipmentController::class, 'trashDestroy'])->name('medical-equipments.trash_destroy');
    // Restore
    Route::resource('medical-equipments',  MedicalEquipmentController::class);

    // ComputerEquipments
    // Available - Request
    Route::get('computer-equipments/available', [ComputerEquipmentController::class, 'available'])->name('computer-equipments.available');
    Route::get('computer-equipments/apply/{computer_equipment}', [ComputerEquipmentController::class, 'apply'])->name('computer-equipments.apply');
    Route::get('computer-equipments/approve-show/{computer_equipment}', [ComputerEquipmentController::class, 'approveShow'])->name('computer-equipments.approve_show');
    Route::get('computer-equipments/approve/{computer_equipment}', [ComputerEquipmentController::class, 'approve'])->name('computer-equipments.approve');
    Route::get('computer-equipments/decline/{computer_equipment}', [ComputerEquipmentController::class, 'decline'])->name('computer-equipments.decline');
    // Trash - Restore
    Route::get('computer-equipments/trash', [ComputerEquipmentController::class, 'trash'])->name('computer-equipments.trash');
    Route::post('computer-equipments/trash/restore/{computer_equipment}', [ComputerEquipmentController::class, 'restore'])->name('computer-equipments.trash_restore');
    Route::delete('computer-equipments/trash/delete/{computer_equipment}', [ComputerEquipmentController::class, 'trashDestroy'])->name('computer-equipments.trash_destroy');
    // Resource
    Route::resource('computer-equipments', ComputerEquipmentController::class);

    // MedicalEquipamentMovements
    Route::get('medical-equipments-movements/trash', [MedicalEquipmentMovementController::class, 'trash'])->name('medical-equipments-movements.trash');
    Route::post('medical-equipments-movements/trash/restore/{medical_equipments_movement}', [MedicalEquipmentMovementController::class, 'restore'])->name('medical-equipments-movements.trash_restore');
    Route::delete('medical-equipments-movements/trash/delete/{medical_equipments_movement}', [MedicalEquipmentMovementController::class, 'trashDestroy'])->name('medical-equipments-movements.trash_destroy');
    Route::resource('medical-equipments-movements',  MedicalEquipmentMovementController::class);

    // ComputerEquipmentMovements
    Route::get('computer-equipments-movements/trash', [ComputerEquipmentMovementController::class, 'trash'])->name('computer-equipments-movements.trash');
    Route::post('computer-equipments-movements/trash/restore/{computer_equipments_movement}', [ComputerEquipmentMovementController::class, 'restore'])->name('computer-equipments-movements.trash_restore');
    Route::delete('computer-equipments-movements/trash/delete/{computer_equipments_movement}', [ComputerEquipmentMovementController::class, 'trashDestroy'])->name('computer-equipments-movements.trash_destroy');
    Route::resource('computer-equipments-movements', ComputerEquipmentMovementController::class);

    Route::resource('medical-maintenance', MedicalMaintenanceController::class);
    Route::resource('computer-maintenance', ComputerMaintenanceController::class);

    // Stats
    Route::get('stats/{date?}', [StatsController::class, 'index'])->name('stats');

    // Ajax
    Route::post('ajax/get-users-by-deparment', [AjaxController::class, 'getUsersByDeparment'])->name('ajax.getUsersByDeparment');

    // Ajax Categories
    Route::get('ajax/categories', [AjaxController::class, 'getCategories'])->name('ajax.getCategories');
    Route::post('ajax/categories', [AjaxController::class, 'storeCategory'])->name('ajax.storeCategory');

    // Ajax Brands
    Route::resource('brands', BrandController::class);

    // Ajax Models
    Route::resource('models', ModelEController::class);
});
