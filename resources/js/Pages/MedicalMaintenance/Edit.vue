<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomForm from "./Form.vue";
import { formatDate, transforDate } from "@/Utils/format-date";

const props = defineProps({
  medicalEquipmentMovement: {
    type: Object,
    required: true,
  },
  equipments: {
    type: Array,
    required: true,
  },
  current_equipment: {
    type: Object,
    required: true,
  },
  user_movement: {
    type: Object,
    required: true,
  },
  user_responsible: {
    type: Object,
    required: true,
  },
  /* user_assigned: {
    type: Object,
    required: true,
  }, */
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
  return_url: {
    type: String,
    required: true,
  },
});

const dateArr = props.medicalEquipmentMovement.transfer_date.split("/");

const form = useForm({
  /* previous_department_id: props.departments.find(
    (item) => item.id === props.medicalEquipmentMovement.previous_department_id
  ), */
  current_department_id: props.departments.find(
    (item) => item.id === props.medicalEquipmentMovement.current_department_id
  ),
  status_id: props.statuses.find(
    (item) => item.id === props.medicalEquipmentMovement.status_id
  ),
  user_movement_id: props.user_movement,
  user_responsible_id: props.user_responsible,
  user_assigned: props.medicalEquipmentMovement.user_assigned,
  equipment_id: props.current_equipment,
  transfer_date: null,
  transfer_date_fake: transforDate(props.medicalEquipmentMovement.transfer_date),
  period_start: null,
  period_start_fake: transforDate(props.medicalEquipmentMovement.period_start),
  period_end: null,
  period_end_fake: transforDate(props.medicalEquipmentMovement.period_end),
  incidence: props.medicalEquipmentMovement.incidence,
  period: props.medicalEquipmentMovement.period,
});

const handleUpdate = () => {
  form.transfer_date = formatDate(form.transfer_date_fake);
  form.period_start = formatDate(form.period_start_fake);
  form.period_end = formatDate(form.period_end_fake);

  /* form.previous_department_id = form.previous_department_id?.id || null; */
  form.current_department_id = form.current_department_id?.id || null;
  form.user_movement_id = form.user_movement_id?.id || null;
  form.user_responsible_id = form.user_responsible_id?.id || null;
  /* form.user_assigned_id = form.user_assigned_id?.id || null; */
  form.equipment_id = form.equipment_id?.id || null;
  form.status_id = form.status_id?.id || null;

  form.put(
    route("medical-maintenance.update", [
      props.medicalEquipmentMovement.id,
    ]),
    {
      errorBag: "handleUpdate",
      preserveScroll: true,
      onSuccess: () => form.reset(),
      onError: () => {},
    }
  );
};
</script>

<template>
  <AppLayout title="Actualizar mantenimiento de equipo médico">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Actualizar mantenimiento de equipo médico
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
          :actionSubmit="handleUpdate"
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
