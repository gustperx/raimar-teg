<?php

return [

    /* 'administrator' => [
        ['display_name' => 'Acceso administrador', 'permission' => 'administrator:administrator'],
        ['display_name' => 'Acceso gerencia', 'permission' => 'administrator:manager'],
        ['display_name' => 'Acceso técnico', 'permission' => 'administrator:technical'],
    ], */

    'usuarios' => [
        ['display_name' => 'Leer', 'permission' => 'manager:user-read'],
        ['display_name' => 'Crear', 'permission' => 'manager:user-create'],
        ['display_name' => 'Actualizar', 'permission' => 'manager:user-update'],
        ['display_name' => 'Eliminación suave', 'permission' => 'manager:user-delete'],
        ['display_name' => 'Restaurar', 'permission' => 'manager:user-restore'],
        ['display_name' => 'Eliminación fuerte', 'permission' => 'manager:user-force-delete'],
    ],

    'Departamentos' => [
        ['display_name' => 'Leer', 'permission' => 'manager:department-read'],
        ['display_name' => 'Crear', 'permission' => 'manager:department-create'],
        ['display_name' => 'Actualizar', 'permission' => 'manager:department-update'],
        ['display_name' => 'Eliminación suave', 'permission' => 'manager:department-delete'],
        ['display_name' => 'Restaurar', 'permission' => 'manager:department-restore'],
        ['display_name' => 'Eliminación fuerte', 'permission' => 'manager:department-force-delete'],
        ['display_name' => 'Lider departamento', 'permission' => 'manager:department-leader'],
    ],

    /* 'Personal' => [
        ['display_name' => 'Leer', 'permission' => 'manager:staff-read'],
        ['display_name' => 'Crear', 'permission' => 'manager:staff-create'],
        ['display_name' => 'Actualizar', 'permission' => 'manager:staff-update'],
        ['display_name' => 'Eliminación suave', 'permission' => 'manager:staff-delete'],
        ['display_name' => 'Restaurar', 'permission' => 'manager:staff-restore'],
        ['display_name' => 'Eliminación fuerte', 'permission' => 'manager:staff-force-delete'],
    ], */

    'Estados' => [
        ['display_name' => 'Leer', 'permission' => 'technical:status-read'],
        ['display_name' => 'Crear', 'permission' => 'technical:status-create'],
        ['display_name' => 'Actualizar', 'permission' => 'technical:status-update'],
        ['display_name' => 'Eliminación suave', 'permission' => 'technical:status-delete'],
        ['display_name' => 'Restaurar', 'permission' => 'technical:status-restore'],
        ['display_name' => 'Eliminación fuerte', 'permission' => 'technical:status-force-delete'],
    ],

    'Categorías' => [
        ['display_name' => 'Leer', 'permission' => 'technical:categories-read'],
        ['display_name' => 'Crear', 'permission' => 'technical:categories-create'],
        ['display_name' => 'Actualizar', 'permission' => 'technical:categories-update'],
        ['display_name' => 'Eliminación suave', 'permission' => 'technical:categories-delete'],
        ['display_name' => 'Restaurar', 'permission' => 'technical:categories-restore'],
        ['display_name' => 'Eliminación fuerte', 'permission' => 'technical:categories-force-delete'],
    ],

    'Equipos de computo' => [
        ['display_name' => 'Leer', 'permission' => 'technical:computerEquipments-read'],
        ['display_name' => 'Crear', 'permission' => 'technical:computerEquipments-create'],
        ['display_name' => 'Actualizar', 'permission' => 'technical:computerEquipments-update'],
        ['display_name' => 'Eliminación suave', 'permission' => 'technical:computerEquipments-delete'],
        ['display_name' => 'Restaurar', 'permission' => 'technical:computerEquipments-restore'],
        ['display_name' => 'Eliminación fuerte', 'permission' => 'technical:computerEquipments-force-delete'],
    ],

    'Equipos medicos' => [
        ['display_name' => 'Leer', 'permission' => 'technical:medicalEquipments-read'],
        ['display_name' => 'Crear', 'permission' => 'technical:medicalEquipments-create'],
        ['display_name' => 'Actualizar', 'permission' => 'technical:medicalEquipments-update'],
        ['display_name' => 'Eliminación suave', 'permission' => 'technical:medicalEquipments-delete'],
        ['display_name' => 'Restaurar', 'permission' => 'technical:medicalEquipments-restore'],
        ['display_name' => 'Eliminación fuerte', 'permission' => 'technical:medicalEquipments-force-delete'],
    ],

    'Movimientos de equipos de cómputo' => [
        ['display_name' => 'Leer', 'permission' => 'technical:computerEquipmentMovements-read'],
        ['display_name' => 'Crear', 'permission' => 'technical:computerEquipmentMovements-create'],
        ['display_name' => 'Actualizar', 'permission' => 'technical:computerEquipmentMovements-update'],
        ['display_name' => 'Eliminación suave', 'permission' => 'technical:computerEquipmentMovements-delete'],
        ['display_name' => 'Restaurar', 'permission' => 'technical:computerEquipmentMovements-restore'],
        ['display_name' => 'Eliminación fuerte', 'permission' => 'technical:computerEquipmentMovements-force-delete'],
    ],

    'Movimientos de equipos médicos' => [
        ['display_name' => 'Leer', 'permission' => 'technical:medicalEquipmentMovements-read'],
        ['display_name' => 'Crear', 'permission' => 'technical:medicalEquipmentMovements-create'],
        ['display_name' => 'Actualizar', 'permission' => 'technical:medicalEquipmentMovements-update'],
        ['display_name' => 'Eliminación suave', 'permission' => 'technical:medicalEquipmentMovements-delete'],
        ['display_name' => 'Restaurar', 'permission' => 'technical:medicalEquipmentMovements-restore'],
        ['display_name' => 'Eliminación fuerte', 'permission' => 'technical:medicalEquipmentMovements-force-delete'],
    ],

];
