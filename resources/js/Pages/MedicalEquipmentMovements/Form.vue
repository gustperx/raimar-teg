<script setup>
import { computed, ref, watch } from "vue";
import axios from "axios";
import Multiselect from "vue-multiselect";

import Datepicker from "vue3-datepicker";
import { es } from "date-fns/locale";

import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";

const props = defineProps({
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

const URL = "/ajax/get-users-by-deparment";

const c_department_id = computed(() => props.form.current_department_id);
const c_users = computed(() => props.users);

const final_users = ref(c_users.value);

const changeDepartmentHandle = (id) => {
  axios
    .post(URL, { department_id: id })
    .then((response) => {
      const { data } = response;
      console.log(data);
      final_users.value = data;
    })
    .catch((error) => console.log);
};

watch(c_department_id, (newValue, oldValue) => {
  if (newValue) {
    changeDepartmentHandle(newValue.id);
  }
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
      <!-- <div class="col-span-6 sm:col-span-4">
        <JetLabel for="previous_department_id" value="Departamento anterior" />
        <Multiselect
          v-model="form.previous_department_id"
          :options="departments"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Departamento anterior"
        />
        <JetInputError
          :message="form.errors.previous_department_id"
          class="mt-2"
        />
      </div> -->

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
          group-values="items"
          group-label="label"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Equipo medicó"
        />
        <JetInputError :message="form.errors.equipment_id" class="mt-2" />
      </div>

      <!-- Estado -->
      <!-- <div class="col-span-6 sm:col-span-4">
        <JetLabel for="status_id" value="Estado actual al momento de mover" />
        <Multiselect
          v-model="form.status_id"
          :options="statuses"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Estado actual"
        />
        <JetInputError :message="form.errors.status_id" class="mt-2" />
      </div> -->

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
          :options="final_users"
          group-values="items"
          group-label="label"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Responsable de departamento"
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
          :options="final_users"
          group-values="items"
          group-label="label"
          :searchable="true"
          track-by="name"
          label="name"
          placeholder="Responsable del equipo"
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
        />
        <JetInputError :message="form.errors.period_start" class="mt-2" />
      </div>

      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="period_end" value="Fecha final" />
        <Datepicker
          v-model="form.period_end_fake"
          :locale="es"
          class="input mt-1 block w-full"
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
