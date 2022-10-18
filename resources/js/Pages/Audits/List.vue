<script setup>
import { Link } from "@inertiajs/inertia-vue3";

import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetPrimaryButton from "@/Jetstream/PrimaryButton.vue";

import CustomTableList from "@/Components/TableList.vue";

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
        <th class="text-left text-white p-4 font-bold">Usuario</th>
        <th class="text-left text-white p-4 font-bold">Actividad</th>
        <th class="text-left text-white p-4 font-bold">Fecha</th>
      </tr>
    </template>

    <template #body>
      <tr
        v-for="{
          id,
          module,
          event,
          user,
          department,
          created_at,
        } in items"
        :key="id"
        class="border-b hover:bg-gray-50"
      >
        <td class="p-4">{{ id }}</td>
        <td class="p-4">
          <ul>
            <li><span class="font-semibold">Usuario:</span> {{ user }}</li>
            <li><span class="font-semibold">Departamento:</span> {{ department }}</li>
          </ul>
        </td>
        <td class="p-4">
          <ul>
            <li><span class="font-semibold">Modulo:</span> {{ module }}</li>
            <li><span class="font-semibold">Evento:</span> {{ event }}</li>
          </ul>
        </td>
        <td class="p-4">{{ created_at }}</td>
      </tr>
    </template>
  </CustomTableList>
</template>
