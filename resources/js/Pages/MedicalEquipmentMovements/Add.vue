<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomForm from "./Form.vue";

defineProps({
  return_url: {
    type: String,
    required: true,
  },
  equipments: {
    type: Array,
    required: true,
  },
  statuses: {
    type: Array,
    required: true,
  },
  users: {
    type: Array,
    required: true,
  },
  usersTech: {
    type: Array,
    required: true,
  },
  departments: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  /* previous_department_id: null, */
  current_department_id: null,
  user_movement_id: null,
  user_responsible_id: null,
  user_assigned: null,
  equipment_id: null,
  /* status_id: null, */
  transfer_date: null,
  transfer_date_fake: new Date(),
  incidence: null,
  period: null
});

const handleCreate = () => {
  const dateOriginal = form.transfer_date_fake;
  const formatDate = `${dateOriginal.getFullYear()}-${
    dateOriginal.getMonth() + 1
  }-${dateOriginal.getDate()}`;

  form.transfer_date = formatDate;
  /* form.previous_department_id = form.previous_department_id?.id || null; */
  form.current_department_id = form.current_department_id?.id || null;
  form.user_movement_id = form.user_movement_id?.id || null;
  form.user_responsible_id = form.user_responsible_id?.id || null;
  /* form.user_assigned_id = form.user_assigned_id?.id || null; */
  form.equipment_id = form.equipment_id?.id || null;
  /* form.status_id = form.status_id?.id || null; */

  form.post(route("medical-equipments-movements.store"), {
    errorBag: "handleCreate",
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {},
  });
};
</script>

<template>
  <AppLayout title="Nuevo movimiento de equipo médico">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Nuevo movimiento de equipo médico
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row justify-between pb-2">
          <div></div>
          <div>
            <JetButton type="button">
              <Link :href="return_url">Regresar</Link>
            </JetButton>
          </div>
        </div>

        <CustomForm
          :actionSubmit="handleCreate"
          :form="form"
          :equipments="equipments"
          :statuses="statuses"
          :users="users"
          :departments="departments"
          :usersTech="usersTech"
        />
      </div>
    </div>
  </AppLayout>
</template>
