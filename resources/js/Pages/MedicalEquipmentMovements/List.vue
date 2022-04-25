<script setup>
import { Link } from "@inertiajs/inertia-vue3";

import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetPrimaryButton from "@/Jetstream/PrimaryButton.vue";

import CustomTableList from "@/Components/TableList.vue";
import CustomModalDelete from "@/Components/ModalDelete.vue";
import { useDeleteModal } from "@/Composables/useDeleteModal.js";

defineProps({
  items: {
    type: Array,
    required: true,
  },
});

const routeText = "medical-equipments-movements.destroy";

const { isOpenModal, deleteItem, closeModal, confirmDeletion } =
  useDeleteModal(routeText);
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
        <th class="text-left text-white p-4 font-bold"></th>
      </tr>
    </template>

    <template #body>
      <tr
        v-for="{
          id,
          equipment: { description, code, serial },
          status,
          previous_department,
          current_department,
          user_movement,
          user_responsible,
          user_assigned,
          transfer_date,
          incidence,
          show_url,
          edit_url,
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
              <span class="font-semibold">Estatus:</span>
              {{ status }}
            </li>
          </ul>
        </td>
        <td class="p-4">
          <ul class="text-sm">
            <li>{{ description }}</li>
            <li><span class="font-semibold">Código:</span> {{ code }}</li>
            <li><span class="font-semibold">Serial:</span> {{ serial }}</li>
          </ul>
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
        <td>
          <div class="flex flex-col md:flex-row">
            <JetPrimaryButton v-if="can.show" class="mr-2">
              <Link :href="show_url">Detalle</Link>
            </JetPrimaryButton>
            <JetPrimaryButton v-if="can.edit" class="mr-2">
              <Link :href="edit_url">Editar</Link>
            </JetPrimaryButton>
            <JetDangerButton v-if="can.delete" @click="confirmDeletion(id)">
              Eliminar
            </JetDangerButton>
          </div>
        </td>
      </tr>
    </template>
  </CustomTableList>

  <!-- Delete Confirmation Modal -->
  <CustomModalDelete
    :isOpenModal="isOpenModal"
    @onConfirm="deleteItem"
    @onCancel="closeModal"
  />
</template>
