<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomForm from "./Form.vue";

const props = defineProps({
  medicalEquipment: {
    type: Object,
    required: true,
  },
  categories: {
    type: Array,
    required: true,
  },
  statuses: {
    type: Array,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  },
});

const form = useForm({
  description: props.medicalEquipment.description,
  brand: props.medicalEquipment.brand,
  model: props.medicalEquipment.model,
  code: props.medicalEquipment.code,
  serial: props.medicalEquipment.serial,
  category_id: props.medicalEquipment.category_id,
  status_id: props.medicalEquipment.status_id,
});

const handleUpdate = () => {
  form.put(route("medical-equipments.update", [props.medicalEquipment.id]), {
    errorBag: "handleUpdate",
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.name) {
        form.reset("name");
      }
    },
  });
};
</script>

<template>
  <AppLayout title="Actualizar equipo medicó">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Actualizar equipo medicó
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
          :categories="categories"
          :statuses="statuses"
        />
      </div>
    </div>
  </AppLayout>
</template>
