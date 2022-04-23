<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomForm from "./Form.vue";

const props = defineProps({
  department: {
    type: Object,
    required: true,
  },
  principals: {
    type: Array,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  },
});

const form = useForm({
  name: props.department.name,
  parent_id: props.department.parent_id,
});

const handleUpdate = () => {
  form.put(route("departments.update", [props.department.id]), {
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
  <AppLayout title="Actualizar departamento">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Actualizar departamento
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
          :principalsList="principals"
        />
      </div>
    </div>
  </AppLayout>
</template>
