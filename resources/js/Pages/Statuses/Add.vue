<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";

import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";

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
  <AppLayout title="Statuses">
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

        <JetFormSection @submitted="createStatus">
          <template #title> Nuevo estado </template>

          <template #description>
            Los estados permiten determinar cuál es el estado actual de un
            equipo de cómputo o equipo médico y ayuda como indicativo para saber
            si está operativo o en mantenimiento
          </template>

          <template #form>
            <div class="col-span-6 sm:col-span-4">
              <JetLabel for="name" value="Nombre" />
              <JetInput
                id="name"
                v-model="form.name"
                type="text"
                class="mt-1 block w-full"
                autocomplete="off"
              />
              <JetInputError :message="form.errors.name" class="mt-2" />
            </div>
          </template>

          <template #actions>
            <JetActionMessage :on="form.recentlySuccessful" class="mr-3">
              Guardado.
            </JetActionMessage>

            <JetButton
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Guardar
            </JetButton>
          </template>
        </JetFormSection>
      </div>
    </div>
  </AppLayout>
</template>
