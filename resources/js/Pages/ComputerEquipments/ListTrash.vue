<script setup>
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetPrimaryButton from "@/Jetstream/PrimaryButton.vue";

import CustomTableList from "@/Components/TableList.vue";
import CustomModalDelete from "@/Components/ModalDelete.vue";
import CustomModalRestore from "@/Components/ModalRestore.vue";
import { useDeleteModal } from "@/Composables/useDeleteModal.js";

defineProps({
  items: {
    type: Array,
    required: true,
  },
});

const routeTextForceDelete = "computer-equipments.trash_destroy";
const routeTextRestore = "computer-equipments.trash_restore";

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
        <th class="text-left text-white p-4 font-bold">Estatus</th>
        <th class="text-left text-white p-4 font-bold"></th>
      </tr>
    </template>

    <template #body>
      <tr
        v-for="{
          id,
          description,
          code,
          serial,
          category,
          status,
          can,
        } in items"
        :key="id"
        class="border-b hover:bg-gray-50"
      >
        <td class="p-4">{{ id }}</td>
        <td class="p-4">{{ category }}</td>
        <td class="p-4">
          <ul class="text-sm">
            <li>{{ description }}</li>
            <li><span class="font-semibold">Código:</span> {{ code }}</li>
            <li><span class="font-semibold">Serial:</span> {{ serial }}</li>
          </ul>
        </td>
        <td class="p-4">{{ status }}</td>
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
