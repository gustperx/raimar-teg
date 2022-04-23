<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomDetailsTable from "@/Components/DetailsTable.vue";
import CustomDetailsTableItem from "@/Components/DetailsTableItem.vue";

defineProps({
  medicalEquipment: {
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
        Información del equipo medicó
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
          <template #title>{{ medicalEquipment.description }}</template>
          <template #subtitle>Información sobre el equipo medicó.</template>
          <template #content>
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="ID"
              :value="medicalEquipment.id"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Descripción"
              :value="medicalEquipment.description"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Código"
              :value="medicalEquipment.code"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Serial"
              :value="medicalEquipment.serial"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Categoría"
              :value="medicalEquipment.category"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Estatus"
              :value="medicalEquipment.status"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Marca"
              :value="medicalEquipment.brand"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Modelo"
              :value="medicalEquipment.model"
            />
          </template>
        </CustomDetailsTable>
      </div>
    </div>
  </AppLayout>
</template>
