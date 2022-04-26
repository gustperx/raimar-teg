<script setup>
import Multiselect from "@vueform/multiselect";

import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";

defineProps({
  actionSubmit: {
    required: true,
  },
  departments: {
    required: true,
  },
  form: {
    required: true,
  },
});

const allowLoginList = ["No", "Si"];
</script>

<template>
  <JetFormSection @submitted="actionSubmit">
    <template #title> Usuarios </template>

    <template #description> Usuarios del sistema </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="department_id" value="Departamento" />
        <Multiselect v-model="form.department_id" :options="departments" />
        <JetInputError :message="form.errors.department_id" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="name" value="Nombre" />
        <JetInput
          id="name"
          v-model="form.name"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.name" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="email" value="Correo electrónico" />
        <JetInput
          id="email"
          v-model="form.email"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.email" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="dni" value="Documento de identidad" />
        <JetInput
          id="dni"
          v-model="form.dni"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.dni" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="allow_login" value="Permitir iniciar sesión" />
        <Multiselect v-model="form.allow_login" :options="allowLoginList" />
        <JetInputError :message="form.errors.allow_login" class="mt-2" />
      </div>
    </template>

    <template #actions>
      <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
        Guardado.
      </JetActionMessage>

      <JetButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Guardar
      </JetButton>
    </template>
  </JetFormSection>
</template>

<style src="@vueform/multiselect/themes/default.css"></style>
