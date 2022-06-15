<script setup>
import { Link } from "@inertiajs/inertia-vue3";

import JetPrimaryButton from "@/Jetstream/PrimaryButton.vue";

import CustomTableList from "@/Components/TableList.vue";
import StatusColor from "@/Components/StatusColor.vue";
import DescriptionEquipment from "@/Components/DescriptionEquipment.vue";

defineProps({
  items: {
    type: Array,
    required: true,
  },
});

</script>

<template>
  <CustomTableList>
    <template #header>
      <tr class="bg-gray-600">
        <th class="text-left text-white p-4 font-bold">ID</th>
        <th class="text-left text-white p-4 font-bold">Departamentos</th>
        <th class="text-left text-white p-4 font-bold">Equipo</th>
        <th class="text-left text-white p-4 font-bold">Personal</th>
        <th class="text-left text-white p-4 font-bold">Fecha</th>
        <th class="text-left text-white p-4 font-bold">Actualización</th>
        <th class="text-left text-white p-4 font-bold"></th>
      </tr>
    </template>

    <template #body>
      <tr
        v-for="{
          id,
          equipment: { description, code, serial },
          status,
          status_color,
          previous_department,
          current_department,
          user_movement,
          user_responsible,
          user_assigned,
          transfer_date,
          updated_at,
          edit_url,
          show_url,
          can,
        } in items"
        :key="id"
        class="border-b hover:bg-gray-50"
      >
        <td class="p-4">{{ id }}</td>
        <td class="p-4">
          <ul class="text-sm">
            <li>
              <span class="font-semibold">Actual:</span>
              {{ current_department }}
            </li>
            <li>
              <span class="font-semibold">Anterior:</span>
              {{ previous_department }}
            </li>
            <li>
              <StatusColor :color="status_color" :text="status" />
            </li>
          </ul>
        </td>
        <td class="p-4">
          <DescriptionEquipment
            :text="description"
            :code="code"
            :serial="serial"
          />
        </td>
        <td class="p-4">
          <ul class="text-sm">
            <li>
              <span class="font-semibold">Traslado:</span> {{ user_movement }}
            </li>
            <li>
              <span class="font-semibold">Responsable:</span>
              {{ user_responsible }}
            </li>
            <li><span class="font-semibold">Uso:</span> {{ user_assigned }}</li>
          </ul>
        </td>
        <td class="p-4">{{ transfer_date }}</td>
        <td class="p-4">{{ updated_at }}</td>
        <td>
          <div class="flex flex-col md:flex-row">
            <JetPrimaryButton v-if="can.show" class="mr-2">
              <a :href="show_url" target="_blank">Reporte</a>
            </JetPrimaryButton>
            <JetPrimaryButton v-if="can.edit" class="mr-2">
              <Link :href="edit_url">Editar</Link>
            </JetPrimaryButton>
          </div>
        </td>
      </tr>
    </template>
  </CustomTableList>

</template>
