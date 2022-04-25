<script setup>
import Multiselect from "vue-multiselect";
/* import Multiselect from "@vueform/multiselect"; */

import Datepicker from "vue3-datepicker";
import { es } from "date-fns/locale";

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
  equipments: {
    required: true,
  },
  statuses: {
    required: true,
  },
  users: {
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
    <template #title> Movimiento de equipos médicos </template>

    <template #description>
      Registro de seguimiento de equipos por las instalaciones
    </template>

    <template #form>
      <!-- Departamento anterior -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="previous_department_id" value="Departamento anterior" />
        <Multiselect
          v-model="form.previous_department_id"
          :options="departments"
          :searchable="true"
          track-by="name"
          label="name"
        />
        <JetInputError
          :message="form.errors.previous_department_id"
          class="mt-2"
        />
      </div>

      <!-- Departamento a destino -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="current_department_id" value="Departamento a destino" />
        <Multiselect
          v-model="form.current_department_id"
          :options="departments"
          :searchable="true"
          track-by="name"
          label="name"
        />
        <JetInputError
          :message="form.errors.current_department_id"
          class="mt-2"
        />
      </div>

      <!-- Equipo medicó -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="equipment_id" value="Equipo medicó" />
        <Multiselect
          v-model="form.equipment_id"
          :options="equipments"
          group-values="equipments"
          group-label="categories"
          :searchable="true"
          track-by="code"
          label="code"
        />
        <JetInputError :message="form.errors.equipment_id" class="mt-2" />
      </div>

      <!-- Estado -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="status_id" value="Estado actual al momento de mover" />
        <Multiselect
          v-model="form.status_id"
          :options="statuses"
          :searchable="true"
          track-by="name"
          label="name"
        />
        <JetInputError :message="form.errors.status_id" class="mt-2" />
      </div>

      <!-- Técnico -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="user_movement_id" value="Técnico" />
        <Multiselect
          v-model="form.user_movement_id"
          :options="users"
          :searchable="true"
          track-by="name"
          label="name"
        />
        <JetInputError :message="form.errors.user_movement_id" class="mt-2" />
      </div>

      <!-- Responsable de departamento -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel
          for="user_responsible_id"
          value="Responsable de departamento"
        />
        <Multiselect
          v-model="form.user_responsible_id"
          :options="users"
          :searchable="true"
          track-by="name"
          label="name"
        />
        <JetInputError
          :message="form.errors.user_responsible_id"
          class="mt-2"
        />
      </div>

      <!-- Responsable del equipo -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="user_assigned_id" value="Responsable del equipo" />
        <Multiselect
          v-model="form.user_assigned_id"
          :options="users"
          :searchable="true"
          track-by="name"
          label="name"
        />
        <JetInputError :message="form.errors.user_assigned_id" class="mt-2" />
      </div>

      <!-- Fecha de transferencia -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="transfer_date" value="Fecha de transferencia" />
        <Datepicker
          v-model="form.transfer_date_fake"
          :locale="es"
          class="input mt-1 block w-full"
        />
        <JetInputError :message="form.errors.transfer_date" class="mt-2" />
      </div>

      <!-- Incidencia -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="incidence" value="Incidencia" />
        <JetInput
          id="incidence"
          v-model="form.incidence"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.incidence" class="mt-2" />
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
<!-- <style src="@vueform/multiselect/themes/default.css"></style> -->
