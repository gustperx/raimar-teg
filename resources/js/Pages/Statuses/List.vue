<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import TableList from "@/Components/TableList.vue";
import ButtonBlue from "@/Components/ButtonBlue.vue";
import ButtonRed from "@/Components/ButtonRed.vue";
import { ref } from "vue";

import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

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

const confirmDeletion = (itemId) => {
  isOpenModal.value = true;
  form.itemId = itemId;
};

const deleteItem = () => {
  console.log(form.itemId);

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
</script>

<template>
  <TableList>
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
            <ButtonBlue v-if="can.edit">
              <Link :href="edit_url">Editar</Link>
            </ButtonBlue>
            <!-- <ButtonRed v-if="can.delete">
              <Link href="dell">Eliminar</Link>
            </ButtonRed> -->
            <JetDangerButton @click="confirmDeletion(id)">
              Eliminar
            </JetDangerButton>
          </div>
        </td>
      </tr>
    </template>
  </TableList>

  <JetDialogModal :show="isOpenModal" @close="closeModal">
    <template #title> Eliminación suave </template>

    <template #content>
      Esta acción moverá el elemento a la "papelera de reciclaje" el elemento no
      se eliminará de inmediato, pero solo podrá eliminarlo definitivamente o
      recuperarlo, accediendo a la acción de restauración de esta lista de
      elementos.
    </template>

    <template #footer>
      <JetSecondaryButton @click="closeModal"> Cancelar </JetSecondaryButton>

      <JetDangerButton
        class="ml-3"
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
        @click="deleteItem"
      >
        Confirmar
      </JetDangerButton>
    </template>
  </JetDialogModal>
</template>
