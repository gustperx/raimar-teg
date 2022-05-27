<script setup>
import Multiselect from "vue-multiselect";

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
  categories: {
    required: true,
  },
  statuses: {
    required: true,
  },
  departments: {
    required: true,
  },
  form: {
    required: true,
  },
});
</script>

<template>
  <JetFormSection @submitted="actionSubmit">
    <template #title> Equipos médicos </template>

    <template #description>
      Los equipos médicos pertenecen a una misma categoría, solo tiene que
      llenar las características que lo hace único como lo son el código y
      serial, además de la descripción, marca y modelo. También se registra un
      estatus para controlar el mantenimiento de los equipos y determinar su
      operatividad
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="category_id" value="Categoría" />
        <Multiselect
          v-model="form.category_id"
          :options="categories"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Categorías"
        />
        <JetInputError :message="form.errors.category_id" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="description" value="Descripción" />
        <JetInput
          id="description"
          v-model="form.description"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.description" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="brand" value="Marca" />
        <JetInput
          id="brand"
          v-model="form.brand"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.brand" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="model" value="Modelo" />
        <JetInput
          id="model"
          v-model="form.model"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.model" class="mt-2" />
      </div>
      <!-- <div class="col-span-6 sm:col-span-4">
        <JetLabel for="code" value="Código" />
        <JetInput
          id="code"
          v-model="form.code"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.code" class="mt-2" />
      </div> -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="serial" value="Serial" />
        <JetInput
          id="serial"
          v-model="form.serial"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.serial" class="mt-2" />
      </div>
      <!-- <div class="col-span-6 sm:col-span-4">
        <JetLabel for="status_id" value="Estatus" />
        <Multiselect
          v-model="form.status_id"
          :options="statuses"
          :searchable="true"
        />
        <JetInputError :message="form.errors.status_id" class="mt-2" />
      </div> -->

      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="department_id" value="Departamento" />
        <Multiselect
          v-model="form.department_id"
          :options="departments"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Departamento"
        />
        <JetInputError :message="form.errors.department_id" class="mt-2" />
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

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
