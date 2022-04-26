<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomForm from "./Form.vue";

const props = defineProps({
  user: {
    type: Object,
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
  name: props.user.name,
  email: props.user.email,
  dni: props.user.dni,
  allow_login: props.user.allow_login,
  department_id: props.user.department_id,
});

const handleUpdate = () => {
  form.put(route("users.update", [props.user.id]), {
    errorBag: "handleUpdate",
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {},
  });
};
</script>

<template>
  <AppLayout title="Actualizar usuario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Actualizar usuario
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
          :departments="departments"
        />
      </div>
    </div>
  </AppLayout>
</template>
