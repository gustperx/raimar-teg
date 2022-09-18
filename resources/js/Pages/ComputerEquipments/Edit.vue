<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomForm from "./Form.vue";

const props = defineProps({
  computerEquipment: {
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
  description: props.computerEquipment.description,
  brand: props.computerEquipment.brand,
  model: props.computerEquipment.model,
  code: props.computerEquipment.code,
  serial: props.computerEquipment.serial,
  category_id: props.categories.find(item => item.id === props.computerEquipment.category_id),
  status_id: props.statuses.find(item => item.id === props.computerEquipment.status_id),
  department_id: props.departments.find(item => item.id === props.computerEquipment.department_id),
});

const handleUpdate = () => {

  form.department_id = form.department_id?.id || null;
  form.category_id = form.category_id?.id || null;
  form.status_id = form.status_id?.id || null;

  form.brand = form.brand?.id || null;
  form.model = form.model?.id || null;

  form.put(route("computer-equipments.update", [props.computerEquipment.id]), {
    errorBag: "handleUpdate",
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {},
  });
};
</script>

<template>
  <AppLayout title="Actualizar equipo de cómputo">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Actualizar equipo de cómputo
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
          :departments="departments"
        />
      </div>
    </div>
  </AppLayout>
</template>
