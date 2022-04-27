<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomForm from "./FormPermission.vue";

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  permissions: {
    type: Object,
    required: true,
  },
  current_permissions: {
    type: Array,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  },
});

const form = useForm({
  permissions: props.current_permissions,
});

const handleUpdate = () => {
  form.post(route("users.permission_store", [props.user.id]), {
    errorBag: "handleUpdate",
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {},
  });
};
</script>

<template>
  <AppLayout title="Permisos de usuario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Permisos de usuario
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
          :permissions="permissions"
        />
      </div>
    </div>
  </AppLayout>
</template>
