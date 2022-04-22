<script setup>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";

const props = defineProps({
  isOpenModal: {
    required: true,
  },
  forceDelte: {
    type: Boolean,
    default: false,
  },
});

let titleModal = "Eliminación suave";
let contentModal =
  "Esta acción moverá el elemento a la 'papelera de reciclaje' el elemento no se eliminará de inmediato, podrá eliminarlo definitivamente o recuperarlo, accediendo a la acción de restauración de esta lista de elementos.";

if (props.forceDelte) {
  titleModal = "Eliminación definitiva";
  contentModal =
    "Esta acción eliminará definitivamente el elemento y no podrá recuperarlo, esto puede repercutir en la información presentada en el sistema. ¿Está seguro de continuar?";
}

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
    <template #title> {{ titleModal }} </template>

    <template #content> {{ contentModal }} </template>

    <template #footer>
      <JetSecondaryButton @click="closeModal"> Cancelar </JetSecondaryButton>

      <JetDangerButton class="ml-3" @click="deleteItem">
        Confirmar
      </JetDangerButton>
    </template>
  </JetDialogModal>
</template>
