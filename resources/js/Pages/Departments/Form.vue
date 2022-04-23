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
  principalsList: {
    required: true,
  },
  form: {
    required: true,
  },
});
</script>

<template>
  <JetFormSection @submitted="actionSubmit">
    <template #title> Departamentos </template>

    <template #description>
      Los departamentos permiten hacer seguimiento de los distintos equipos
      informáticos / médicos y organizar de manera sistemática la ubicación de
      estos equipos y traquear sus rotaciones.
      <hr class="my-2" />
      También es posible crear sub-departamentos con ayuda del campo
      <span class="text-purple-700 font-semibold">departamento principal</span>
      que por lo general será:
      <hr class="my-2" />
      <ul>
        <li>
          <span class="text-purple-700 font-semibold">1. Departamento</span>
        </li>
        <li>
          <span class="text-purple-700 font-semibold">2. Unidad médica</span>
        </li>
      </ul>
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="parent_id" value="Departamento principal" />
        <Multiselect v-model="form.parent_id" :options="principalsList" />
        <JetInputError :message="form.errors.parent_id" class="mt-2" />
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
