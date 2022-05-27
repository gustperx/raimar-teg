<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomDetailsTable from "@/Components/DetailsTable.vue";
import CustomDetailsTableItem from "@/Components/DetailsTableItem.vue";

import CustomTableList from "@/Components/TableList.vue";
import StatusColor from "@/Components/StatusColor.vue";

defineProps({
  category: {
    type: Object,
    required: true,
  },
  equipments: {
    type: Array,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <AppLayout title="Información de la categoría">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Información de la categoría
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
          <template #title>{{ category.name }}</template>
          <template #subtitle>Información sobre la categoría.</template>
          <template #content>
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="ID"
              :value="category.id"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Nombre"
              :value="category.name"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Categoría principal"
              :value="category.principal"
            />
          </template>
        </CustomDetailsTable>

        <div class="my-12"></div>

        <CustomDetailsTable>
          <template #title>Equipos</template>
          <template #subtitle>Información de ubicación de equipos.</template>
          <template #content>
            <CustomTableList>
              <template #header>
                <tr class="bg-gray-600">
                  <th class="text-left text-white p-4 font-bold">ID</th>
                  <th class="text-left text-white p-4 font-bold">Descripción</th>
                  <th class="text-left text-white p-4 font-bold">Departamento</th>
                  <th class="text-left text-white p-4 font-bold">Estatus</th>
                </tr>
              </template>

              <template #body>
                <tr
                  v-for="equipment in equipments" :key="equipment.id"
                  class="border-b hover:bg-gray-50"
                >
                  <td class="p-4">{{ equipment.id }}</td>
                  <td class="p-4">
                    <ul class="text-sm">
                      <li>{{ equipment.description }}</li>
                      <li><span class="font-semibold">Código:</span> {{ equipment.code }}</li>
                      <li><span class="font-semibold">Serial:</span> {{ equipment.serial }}</li>
                    </ul>
                  </td>
                  <td class="p-4">{{ equipment.department.name }}</td>
                  <td class="p-4">
                    <StatusColor :color="equipment.status.color" :text="equipment.status.name" />
                  </td>
                </tr>
              </template>
            </CustomTableList>
          </template>
        </CustomDetailsTable>
      </div>
    </div>
  </AppLayout>
</template>
