<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomForm from "./Form.vue";

const props = defineProps({
  medicalEquipmentMovement: {
    type: Object,
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
  departments: {
    type: Array,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  },
});

const form = useForm({
  previous_department_id: props.medicalEquipmentMovement.previous_department_id,
  current_department_id: props.medicalEquipmentMovement.current_department_id,
  user_movement_id: props.medicalEquipmentMovement.user_movement_id,
  user_responsible_id: props.medicalEquipmentMovement.user_responsible_id,
  user_assigned_id: props.medicalEquipmentMovement.user_assigned_id,
  equipment_id: props.medicalEquipmentMovement.equipment_id,
  status_id: props.medicalEquipmentMovement.status_id,
  transfer_date: props.medicalEquipmentMovement.transfer_date,
  incidence: props.medicalEquipmentMovement.incidence,
});

const handleUpdate = () => {
  form.put(
    route("medical-equipments-movements.update", [
      props.medicalEquipmentMovement.id,
    ]),
    {
      errorBag: "handleUpdate",
      preserveScroll: true,
      onSuccess: () => form.reset(),
      onError: () => {
        if (form.errors.name) {
          form.reset("name");
        }
      },
    }
  );
};
</script>

<template>
  <AppLayout title="Actualizar movimiento de equipo médico">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Actualizar movimiento de equipo médico
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
        />
      </div>
    </div>
  </AppLayout>
</template>
