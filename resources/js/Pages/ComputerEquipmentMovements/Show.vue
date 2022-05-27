<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomDetailsTable from "@/Components/DetailsTable.vue";
import CustomDetailsTableItem from "@/Components/DetailsTableItem.vue";

defineProps({
  computerEquipmentMovement: {
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
  <AppLayout title="Información del equipo informáticos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Información del movimiento de equipo informático
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
            computerEquipmentMovement.equipment.description
          }}</template>
          <template #subtitle
            >Información sobre el movimiento de equipo informático.</template
          >
          <template #content>
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="ID"
              :value="computerEquipmentMovement.id"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Descripción"
              :value="computerEquipmentMovement.equipment.description"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Código"
              :value="computerEquipmentMovement.equipment.code"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Serial"
              :value="computerEquipmentMovement.equipment.serial"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Departamento anterior"
              :value="computerEquipmentMovement.previous_department"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Departamento a mover"
              :value="computerEquipmentMovement.current_department"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Técnico"
              :value="computerEquipmentMovement.user_movement"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Responsable de departamento"
              :value="computerEquipmentMovement.user_responsible"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Responsable del equipo"
              :value="computerEquipmentMovement.user_assigned"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Estado actual al momento de mover"
              :value="computerEquipmentMovement.status"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Fecha de transferencia"
              :value="computerEquipmentMovement.transfer_date"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Incidencia"
              :value="computerEquipmentMovement.incidence"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Periodo"
              :value="computerEquipmentMovement.period"
            />
          </template>
        </CustomDetailsTable>
      </div>
    </div>
  </AppLayout>
</template>
