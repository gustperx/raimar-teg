<script setup>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

defineProps({
  isOpenModal: {
    required: true,
  },
});

const emit = defineEmits(["onCancel", "onConfirm"]);

const restoreItem = () => {
  emit("onConfirm");
};

const closeModal = () => {
  emit("onCancel");
};
</script>

<template>
  <JetDialogModal :show="isOpenModal" @close="closeModal">
    <template #title> Restaurar elemento </template>

    <template #content>
      Esta acción restaurará el elemento y lo moverá a la lista principal
    </template>

    <template #footer>
      <JetSecondaryButton @click="closeModal"> Cancelar </JetSecondaryButton>

      <JetButton class="ml-3" @click="restoreItem"> Confirmar </JetButton>
    </template>
  </JetDialogModal>
</template>
