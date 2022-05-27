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
});

const form = useForm({
  description: null,
  brand: null,
  model: null,
  code: null,
  serial: null,
  category_id: null,
  status_id: null,
  department_id: null,
});

const handleCreate = () => {

  form.department_id = form.department_id?.id || null;
  form.category_id = form.category_id?.id || null;
  form.status_id = form.status_id?.id || null;

  form.post(route("computer-equipments.store"), {
    errorBag: "handleCreate",
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {},
  });
};
</script>

<template>
  <AppLayout title="Nuevo equipo de cómputo">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Nuevo equipo de cómputo
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
          :categories="categories"
          :statuses="statuses"
          :departments="departments"
        />
      </div>
    </div>
  </AppLayout>
</template>
