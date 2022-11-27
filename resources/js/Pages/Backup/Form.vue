<script setup>

import JetActionMessage from "@/Jetstream/ActionMessage.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetButton from "@/Jetstream/Button.vue";

defineProps({
  actionSubmit: {
    required: true,
  },
  form: {
    required: true,
  },
});
</script>

<template>
  <JetFormSection @submitted="actionSubmit">
    <template #title> Restaurar </template>

    <template #description>
      
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="database_file" value="Base de datos" />
        <input type="file" @input="form.database_file = $event.target.files[0]" />
        <JetInputError :message="form.errors.database_file" class="mt-2" />
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
        Subir
      </JetButton>
    </template>
  </JetFormSection>
</template>

