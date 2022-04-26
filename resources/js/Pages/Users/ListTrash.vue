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

const routeTextForceDelete = "users.trash_destroy";
const routeTextRestore = "users.trash_restore";

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
        <th class="text-left text-white p-4 font-bold">Usuario</th>
        <th class="text-left text-white p-4 font-bold">Departamento</th>
        <th class="text-left text-white p-4 font-bold">Permitir acceso</th>
        <th class="text-left text-white p-4 font-bold"></th>
      </tr>
    </template>

    <template #body>
      <tr
        v-for="{ id, name, email, dni, allow_login, department, can } in items"
        :key="id"
        class="border-b hover:bg-gray-50"
      >
        <td class="p-4">{{ id }}</td>
        <td class="p-4">
          <ul>
            <li>{{ name }}</li>
            <li>{{ email }}</li>
            <li>{{ dni }}</li>
          </ul>
        </td>
        <td class="p-4">{{ department }}</td>
        <td class="p-4">{{ allow_login }}</td>
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
