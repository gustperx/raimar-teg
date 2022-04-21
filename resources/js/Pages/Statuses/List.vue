<script setup>
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";

import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetPrimaryButton from "@/Jetstream/PrimaryButton.vue";

import CustomTableList from "@/Components/TableList.vue";
import CustomModalDelete from "@/Components/ModalDelete.vue";

defineProps({
  statuses: {
    type: Array,
    required: true,
  },
});

const isOpenModal = ref(false);
const form = useForm({
  itemId: "",
});

const deleteItem = () => {
  form.delete(route("statuses.destroy", [form.itemId]), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  isOpenModal.value = false;
  form.reset();
};

const confirmDeletion = (itemId) => {
  isOpenModal.value = true;
  form.itemId = itemId;
};
</script>

<template>
  <CustomTableList>
    <template #header>
      <tr class="bg-gray-600">
        <th class="text-left text-white p-4 font-bold">ID</th>
        <th class="text-left text-white p-4 font-bold">Nombre</th>
        <th class="text-left text-white p-4 font-bold"></th>
      </tr>
    </template>

    <template #body>
      <tr
        v-for="{ id, name, edit_url, can } in statuses"
        :key="id"
        class="border-b hover:bg-gray-50"
      >
        <td class="p-4">{{ id }}</td>
        <td class="p-4">{{ name }}</td>
        <td>
          <div class="flex flex-col md:flex-row">
            <JetPrimaryButton v-if="can.edit" class="mr-2">
              <Link :href="edit_url">Editar</Link>
            </JetPrimaryButton>
            <JetDangerButton @click="confirmDeletion(id)">
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
