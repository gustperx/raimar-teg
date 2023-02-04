<script setup>
import { onMounted } from "vue";
import { Printd } from "printd";
import BarCode from "@/Components/BarCode.vue";

defineProps({
  medicalEquipmentMovement: {
    type: Object,
    required: true,
  },
});

const d = new Printd();
const styles = [
  '/css/app.css'
];

onMounted(() => d.print( document.getElementById('print-div'), styles ));

</script>

<template>
  <div class="py-12" id="print-div">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="flex justify-between">
        <div class="text-2xl font-bold text-blue-800">
          Reporte #{{ medicalEquipmentMovement.id }}
        </div>
        <div>
          <img src="/img/cli_lug.png" class="w-20 -mb-8" alt="cli_lig" />
        </div>
      </div>

      <div class="flex justify-between">
        <div class="text-lg font-bold">
          <span class="text-blue-800">Generado por: </span> {{ $page.props.user.name }}
        </div>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Movimiento de equipo médico</h3>
        <h3 class="text-lg">Fecha de creación: {{ medicalEquipmentMovement.created_at }}</h3>
        <h3 class="text-lg">Fecha de modificación: {{ medicalEquipmentMovement.updated_at }}</h3>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Incidencia:</h3>
        <p>{{ medicalEquipmentMovement.incidence }}</p>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Descripción del Equipo:</h3>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <span class="font-semibold">Código:</span>
          {{ medicalEquipmentMovement.equipment.code }}
        </div>
        <div>
          <span class="font-semibold">Serial:</span>
          {{ medicalEquipmentMovement.equipment.serial }}
        </div>
        <div>
          <span class="font-semibold">Marca:</span>
          {{ medicalEquipmentMovement.equipment.brand }}
        </div>
        <div>
          <span class="font-semibold">Modelo:</span>
          {{ medicalEquipmentMovement.equipment.model }}
        </div>
        <div>
          <span class="font-semibold">Descripción:</span>
          {{ medicalEquipmentMovement.equipment.description }}
        </div>
        <div>
          <span class="font-semibold">Estado:</span>
          {{ medicalEquipmentMovement.status }}
        </div>
        <div>
          <BarCode :code="medicalEquipmentMovement.equipment.code" />
        </div>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Departamento:</h3>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <span class="font-semibold">Anterior:</span>
          {{ medicalEquipmentMovement.previous_department }}
        </div>
        <div>
          <span class="font-semibold">Actual:</span>
          {{ medicalEquipmentMovement.current_department }}
        </div>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Personal:</h3>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <span class="font-semibold">Técnico:</span>
          {{ medicalEquipmentMovement.user_movement }}
        </div>
        <div>
          <span class="font-semibold">Departamento:</span>
          {{ medicalEquipmentMovement.user_responsible }}
        </div>
        <div>
          <span class="font-semibold">Responsable:</span>
          {{ medicalEquipmentMovement.user_assigned }}
        </div>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Fechas:</h3>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <span class="font-semibold">Periodo Inicio:</span>
          {{ medicalEquipmentMovement.period_start }}
        </div>
        <div>
          <span class="font-semibold">Periodo Fin:</span>
          {{ medicalEquipmentMovement.period_end }}
        </div>
        <div>
          <span class="font-semibold">Fecha de transferencia:</span>
          {{ medicalEquipmentMovement.transfer_date }}
        </div>
      </div>
    </div>
  </div>
</template>
