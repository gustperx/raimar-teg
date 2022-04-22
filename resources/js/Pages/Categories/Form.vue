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
    <template #title> Categorías </template>

    <template #description>
      Las categorías permiten clasificar los distintos equipos manejados por el
      sistema, evitar la duplicidad de elementos y entregar información precisa.
      <hr class="my-2" />
      También es posible crear sub-categorías con ayuda del campo
      <span class="text-purple-700 font-semibold">categoría principal</span>
      que por lo general será:
      <hr class="my-2" />
      <ul>
        <li>
          <span class="text-purple-700 font-semibold">1. Equipos médicos</span>
        </li>
        <li>
          <span class="text-purple-700 font-semibold"
            >2. Equipos informáticos</span
          >
        </li>
      </ul>
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="parent_id" value="Categoría principal" />
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
