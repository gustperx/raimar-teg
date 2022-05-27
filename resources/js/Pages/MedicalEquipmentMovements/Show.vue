<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomDetailsTable from "@/Components/DetailsTable.vue";
import CustomDetailsTableItem from "@/Components/DetailsTableItem.vue";

defineProps({
  medicalEquipmentMovement: {
    type: Object,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <AppLayout title="Información del equipo medicó">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Información del movimiento de equipo médico
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row justify-between pb-2">
          <div></div>
          <div>
            <JetButton type="button">
              <Link :href="return_url">Regresar</Link>
            </JetButton>
          </div>
        </div>

        <CustomDetailsTable>
          <template #title>{{
            medicalEquipmentMovement.equipment.description
          }}</template>
          <template #subtitle
            >Información sobre el movimiento de equipo médico.</template
          >
          <template #content>
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="ID"
              :value="medicalEquipmentMovement.id"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Descripción"
              :value="medicalEquipmentMovement.equipment.description"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Código"
              :value="medicalEquipmentMovement.equipment.code"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Serial"
              :value="medicalEquipmentMovement.equipment.serial"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Departamento anterior"
              :value="medicalEquipmentMovement.previous_department"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Departamento a mover"
              :value="medicalEquipmentMovement.current_department"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Técnico"
              :value="medicalEquipmentMovement.user_movement"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Responsable de departamento"
              :value="medicalEquipmentMovement.user_responsible"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Responsable del equipo"
              :value="medicalEquipmentMovement.user_assigned"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Estado actual al momento de mover"
              :value="medicalEquipmentMovement.status"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Fecha de transferencia"
              :value="medicalEquipmentMovement.transfer_date"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Incidencia"
              :value="medicalEquipmentMovement.incidence"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Periodo"
              :value="medicalEquipmentMovement.period"
            />
          </template>
        </CustomDetailsTable>
      </div>
    </div>
  </AppLayout>
</template>
