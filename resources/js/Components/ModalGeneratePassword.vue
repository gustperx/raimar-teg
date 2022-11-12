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
    <template #title> Generar contraseña </template>

    <template #content>
      Esta acción generará una nueva contraseña para el usuario y la actualizará
      en la base de datos
    </template>

    <template #footer>
      <JetSecondaryButton @click="closeModal"> Cancelar </JetSecondaryButton>

      <JetButton class="ml-3" @click="restoreItem"> Confirmar </JetButton>
    </template>
  </JetDialogModal>
</template>
