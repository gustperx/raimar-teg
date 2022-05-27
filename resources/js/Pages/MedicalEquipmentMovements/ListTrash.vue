<script setup>
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetPrimaryButton from "@/Jetstream/PrimaryButton.vue";

import CustomTableList from "@/Components/TableList.vue";
import CustomModalDelete from "@/Components/ModalDelete.vue";
import CustomModalRestore from "@/Components/ModalRestore.vue";
import DescriptionEquipment from "@/Components/DescriptionEquipment.vue";
import { useDeleteModal } from "@/Composables/useDeleteModal.js";

defineProps({
  items: {
    type: Array,
    required: true,
  },
});

const routeTextForceDelete = "medical-equipments-movements.trash_destroy";
const routeTextRestore = "medical-equipments-movements.trash_restore";

const { isOpenModal, deleteItem, closeModal, confirmDeletion } =
  useDeleteModal(routeTextForceDelete);

const {
  restoreItem,
  confirmRestoration,
  closeModal: closeModalRestore,
  isOpenModal: isOpenModalRestore,
} = useDeleteModal(routeTextRestore);
</script>

<template>
  <CustomTableList>
    <template #header>
      <tr class="bg-gray-600">
        <th class="text-left text-white p-4 font-bold">ID</th>
        <th class="text-left text-white p-4 font-bold">Categoría</th>
        <th class="text-left text-white p-4 font-bold">Descripción</th>
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
        <td>
          <div class="flex flex-col md:flex-row">
            <JetPrimaryButton
              v-if="can.restore"
              @click="confirmRestoration(id)"
              class="mr-2"
            >
              Restaurar
            </JetPrimaryButton>
            <JetDangerButton
              v-if="can.forceDelete"
              @click="confirmDeletion(id)"
            >
              Forzar eliminación
            </JetDangerButton>
          </div>
        </td>
      </tr>
    </template>
  </CustomTableList>

  <!-- Delete Confirmation Modal -->
  <CustomModalDelete
    :isOpenModal="isOpenModal"
    forceDelte
    @onConfirm="deleteItem"
    @onCancel="closeModal"
  />

  <!-- Restore Confirmation Modal -->
  <CustomModalRestore
    :isOpenModal="isOpenModalRestore"
    @onConfirm="restoreItem"
    @onCancel="closeModalRestore"
  />
</template>
