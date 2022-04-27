<script setup>
import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetButton from "@/Jetstream/Button.vue";

defineProps({
  actionSubmit: {
    required: true,
  },
  permissions: {
    required: true,
  },
  form: {
    required: true,
  },
});
</script>

<template>
  <JetFormSection @submitted="actionSubmit">
    <template #title> Permisos </template>

    <template #description> Permisos de usuario </template>

    <template #form>
      <div
        v-for="(list, name) in permissions"
        :key="name"
        class="col-span-6 sm:col-span-4"
      >
        <div>
          <h3 class="font-semibold">{{ name }}</h3>
          <hr class="py-2" />
        </div>
        <div class="grid grid-cols-2 gap-2">
          <div v-for="(permission, tag) in list" :key="permission" class="">
            <input
              type="checkbox"
              :id="permission"
              :value="permission"
              v-model="form.permissions"
            />
            <label
              :for="permission"
              class="font-medium text-sm text-gray-700 pl-2"
            >
              {{ tag }}
            </label>
          </div>
        </div>
      </div>
      <JetInputError :message="form.errors.permissions" class="mt-2" />
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
</template>
