<script setup>
import Multiselect from "vue-multiselect";

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
  usersTech: {
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
    <template #title> Mantenimiento de equipos de cómputo </template>

    <template #description>

    </template>

    <template #form>

      <!-- Departamento a destino -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="current_department_id" value="Departamento destino" />
        <Multiselect
          v-model="form.current_department_id"
          :options="departments"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Departamento destino"
          :show-labels="false"
          :showNoOptions="false"
        />
        <JetInputError
          :message="form.errors.current_department_id"
          class="mt-2"
        />
      </div>

      <!-- Equipo medicó -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="equipment_id" value="Equipo de cómputo" />
        <Multiselect
          v-model="form.equipment_id"
          :options="equipments"
          group-values="items"
          group-label="label"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Equipo de cómputo"
          :show-labels="false"
          :showNoOptions="false"
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
          placeholder="Estado actual"
          :show-labels="false"
          :showNoOptions="false"
        />
        <JetInputError :message="form.errors.status_id" class="mt-2" />
      </div>

      <!-- Técnico -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="user_movement_id" value="Técnico" />
        <Multiselect
          v-model="form.user_movement_id"
          :options="usersTech"
          group-values="items"
          group-label="label"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Técnico"
          :show-labels="false"
          :showNoOptions="false"
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
          group-values="items"
          group-label="label"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Responsable de departamento"
          :show-labels="false"
          :showNoOptions="false"
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
          group-values="items"
          group-label="label"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Responsable del equipo"
          :show-labels="false"
          :showNoOptions="false"
        />
        <!-- <JetInput
          id="user_assigned"
          v-model="form.user_assigned"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        /> -->
        <JetInputError :message="form.errors.user_assigned_id" class="mt-2" />
      </div>

      <!-- Fecha de transferencia -->
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="transfer_date" value="Fecha de transferencia" />
        <Datepicker
          v-model="form.transfer_date_fake"
          :locale="es"
          class="input mt-1 block w-full"
          inputFormat="dd-MM-yyyy"
          :lowerLimit="form.transfer_date_fake"
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

      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="period_start" value="Fecha de inicio" />
        <Datepicker
          v-model="form.period_start_fake"
          :locale="es"
          class="input mt-1 block w-full"
          inputFormat="dd-MM-yyyy"
          :lowerLimit="form.period_start_fake"
        />
        <JetInputError :message="form.errors.period_start" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="period_end" value="Fecha final" />
        <Datepicker
          v-model="form.period_end_fake"
          :locale="es"
          class="input mt-1 block w-full"
          inputFormat="dd-MM-yyyy"
          :lowerLimit="form.period_start_fake"
        />
        <JetInputError :message="form.errors.period_end" class="mt-2" />
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
