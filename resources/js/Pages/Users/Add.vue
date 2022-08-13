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
  departments: {
    type: Array,
    required: true,
  },
  dniTypes: {
    type: Array,
    required: true,
  },
  genderTypes: {
    type: Array,
    required: true,
  },
  allowLoginList: {
    type: Array,
    required: true,
  },
  permissions: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  name: null,
  email: null,
  dni: null,
  allow_login: 0,
  department_id: 4,
  dni_type: 'V',
  permissions: [],
  address: null,
  phone: null,
  gender: null
});

const handleCreate = () => {
  form.post(route("users.store"), {
    errorBag: "handleCreate",
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {},
  });
};
</script>

<template>
  <AppLayout title="Nuevo usuario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Nuevo usuario
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
          :departments="departments"
          :allowLoginList="allowLoginList"
          :permissions="permissions"
          :dniTypes="dniTypes"
          :genderTypes="genderTypes"
        />
      </div>
    </div>
  </AppLayout>
</template>
