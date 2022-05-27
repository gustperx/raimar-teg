<script setup>
import { Link } from "@inertiajs/inertia-vue3";

import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetPrimaryButton from "@/Jetstream/PrimaryButton.vue";

import CustomTableList from "@/Components/TableList.vue";
import CustomModalDelete from "@/Components/ModalDelete.vue";
import StatusColor from "@/Components/StatusColor.vue";
import { useDeleteModal } from "@/Composables/useDeleteModal.js";

defineProps({
  items: {
    type: Array,
    required: true,
  },
});

const routeText = "statuses.destroy";

const { isOpenModal, deleteItem, closeModal, confirmDeletion } =
  useDeleteModal(routeText);
</script>

<template>
  <CustomTableList>
    <template #header>
      <tr class="bg-gray-600">
        <th class="text-left text-white p-4 font-bold">ID</th>
        <th class="text-left text-white p-4 font-bold">Nombre</th>
        <th class="text-left text-white p-4 font-bold">Color</th>
        <th class="text-left text-white p-4 font-bold"></th>
      </tr>
    </template>

    <template #body>
      <tr
        v-for="{ id, name, color, show_url, edit_url, can } in items"
        :key="id"
        class="border-b hover:bg-gray-50"
      >
        <td class="p-4">{{ id }}</td>
        <td class="p-4">{{ name }}</td>
        <td class="p-4">
          <StatusColor :color="color" />
        </td>
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
