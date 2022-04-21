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
});

const form = useForm({
  name: null,
});

const createStatus = () => {
  form.post(route("statuses.store"), {
    errorBag: "createStatus",
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
  <AppLayout title="Nuevo estado">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Nuevo estado
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

        <CustomForm :actionSubmit="createStatus" :form="form" />
      </div>
    </div>
  </AppLayout>
</template>
