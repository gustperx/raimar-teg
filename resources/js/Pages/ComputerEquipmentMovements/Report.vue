<script setup>
import { onMounted } from "vue";
import { Printd } from "printd";
import BarCode from "@/Components/BarCode.vue";

defineProps({
  computerEquipmentMovement: {
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
          Reporte #{{ computerEquipmentMovement.id }}
        </div>
        <div>
          <img src="/img/cli_lug.png" class="w-20 -mb-8" alt="cli_lig" />
        </div>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Movimiento de equipo informático</h3>
        <h3 class="text-lg">Fecha de creación: {{ computerEquipmentMovement.created_at }}</h3>
        <h3 class="text-lg">Fecha de modificación: {{ computerEquipmentMovement.updated_at }}</h3>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Incidencia:</h3>
        <p>{{ computerEquipmentMovement.incidence }}</p>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Descripción del Equipo:</h3>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <span class="font-semibold">Código:</span> 
          {{ computerEquipmentMovement.equipment.code }}
        </div>
        <div>
          <span class="font-semibold">Serial:</span> 
          {{ computerEquipmentMovement.equipment.serial }}
        </div>
        <div>
          <span class="font-semibold">Marca:</span> 
          {{ computerEquipmentMovement.equipment.brand }}
        </div>
        <div>
          <span class="font-semibold">Modelo:</span> 
          {{ computerEquipmentMovement.equipment.model }}
        </div>
        <div>
          <span class="font-semibold">Descripción:</span> 
          {{ computerEquipmentMovement.equipment.description }}
        </div>
        <div>
          <span class="font-semibold">Estado:</span> 
          {{ computerEquipmentMovement.status }}
        </div>
        <div>
          <BarCode :code="computerEquipmentMovement.equipment.code" />
        </div>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Departamento:</h3>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <span class="font-semibold">Anterior:</span> 
          {{ computerEquipmentMovement.previous_department }}
        </div>
        <div>
          <span class="font-semibold">Actual:</span> 
          {{ computerEquipmentMovement.current_department }}
        </div>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Personal:</h3>
      </div>

      <div class="grid grid-cols-2 gap-2">
        <div>
          <span class="font-semibold">Técnico:</span> 
          {{ computerEquipmentMovement.user_movement }}
        </div>
        <div>
          <span class="font-semibold">Departamento:</span> 
          {{ computerEquipmentMovement.user_responsible }}
        </div>
        <div>
          <span class="font-semibold">Responsable:</span> 
          {{ computerEquipmentMovement.user_assigned }}
        </div>
      </div>

      <div class="my-4">
        <h3 class="text-2xl font-semibold text-blue-800">Fechas:</h3>
      </div>

      <div class="grid grid-cols-2 gap-2">       
        <div>
          <span class="font-semibold">Periodo Inicio:</span> 
          {{ computerEquipmentMovement.period_start }}
        </div>
        <div>
          <span class="font-semibold">Periodo Fin:</span> 
          {{ computerEquipmentMovement.period_end }}
        </div>
        <div>
          <span class="font-semibold">Fecha de transferencia:</span> 
          {{ computerEquipmentMovement.transfer_date }}
        </div>
      </div>
    </div>
  </div>
</template>
