<script setup>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetPrimaryButton from "@/Jetstream/PrimaryButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetLabel from "@/Jetstream/Label.vue";

const props = defineProps({
  isOpenModal: {
    required: true,
  },
  form: {
    required: true,
  }
});

const emit = defineEmits(["onCancel", "onConfirm"]);

const sendItem = () => {
  emit("onConfirm");
};

const closeModal = () => {
  emit("onCancel");
};
</script>

<template>
  <JetDialogModal :show="isOpenModal" @close="closeModal">
    <template #title>Agregar Nuevo </template>

    <template #content>
      <JetLabel for="name_brand" value="Nombre" />
      <JetInput
        id="name_brand"
        v-model="form.name"
        type="text"
        class="mt-1 block w-full"
        autocomplete="off"
      />
    </template>

    <template #footer>
      <JetSecondaryButton @click="closeModal"> Cancelar </JetSecondaryButton>

      <JetPrimaryButton class="ml-3" @click="sendItem">
        Guardar
      </JetPrimaryButton>
    </template>
  </JetDialogModal>
</template>
