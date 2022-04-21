<script setup>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

defineProps({
  isOpenModal: {
    required: true,
  },
});

const emit = defineEmits(["onCancel", "onConfirm"]);

const deleteItem = () => {
  emit("onConfirm");
};

const closeModal = () => {
  emit("onCancel");
};
</script>

<template>
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

      <JetDangerButton class="ml-3" @click="deleteItem">
        Confirmar
      </JetDangerButton>
    </template>
  </JetDialogModal>
</template>
