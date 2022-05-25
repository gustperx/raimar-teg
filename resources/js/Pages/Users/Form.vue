<script setup>
import Multiselect from "@vueform/multiselect";

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
  departments: {
    required: true,
  },
  permissions: {
    required: false,
  },
  allowLoginList: {
    required: true,
  },
  form: {
    required: true,
  },
});
</script>

<template>
  <JetFormSection @submitted="actionSubmit">
    <template #title> Usuarios </template>

    <template #description> Usuarios del sistema </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="department_id" value="Departamento" />
        <Multiselect v-model="form.department_id" :options="departments" />
        <JetInputError :message="form.errors.department_id" class="mt-2" />
      </div>
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
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="email" value="Correo electrónico" />
        <JetInput
          id="email"
          v-model="form.email"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.email" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="dni" value="Documento de identidad" />
        <JetInput
          id="dni"
          v-model="form.dni"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.dni" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="allow_login" value="Permitir iniciar sesión" />
        <Multiselect v-model="form.allow_login" :options="allowLoginList" />
        <JetInputError :message="form.errors.allow_login" class="mt-2" />
      </div>

      <div v-if="permissions" class="col-span-6 sm:col-span-4">
        <span class="text-lg text-semibold my-4">Permisos</span>
        <div v-for="(list, name) in permissions" :key="name">
          <div>
            <h3 class="font-semibold">{{ name }}</h3>
            <hr class="py-2" />
          </div>
          <div class="grid grid-cols-2 gap-2 my-1">
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
        <div class="col-span-6 sm:col-span-4">
          <JetInputError :message="form.errors.permissions" class="mt-2" />
        </div>
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
</template>

<style src="@vueform/multiselect/themes/default.css"></style>
