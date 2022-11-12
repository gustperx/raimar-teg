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
  dniTypes: {
    required: true,
  },
  genderTypes: {
    required: true,
  },
  permissions: {
    required: false,
  },
  allowLoginList: {
    required: true,
  },
  codeTypes: {
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

    <template #description>
      <div v-if="permissions" class="col-span-6 sm:col-span-4">
        <div v-for="(list, name) in permissions" :key="name">
          <div>
            <h3 class="font-bold mt-4 mb-2"> - {{ name }}</h3>
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
        <div class="col-span-6 sm:col-span-4">
          <JetInputError :message="form.errors.permissions" class="mt-2" />
        </div>
      </div>
    </template>

    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="department_id" value="Departamento" />
        <Multiselect v-model="form.department_id" :options="departments" noOptionsText />
        <JetInputError :message="form.errors.department_id" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="name" value="Nombre y Apellido" />
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
        <JetLabel for="gender" value="Género" />
        <Multiselect v-model="form.gender" :options="genderTypes" />
        <JetInputError :message="form.errors.gender" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="dni_type" value="Nacionalidad" />
        <Multiselect v-model="form.dni_type" :options="dniTypes" />
        <JetInputError :message="form.errors.dni_type" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="dni" value="Cedula de Identidad" />
        <JetInput
          id="dni"
          v-model="form.dni"
          type="number"
          min="0"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.dni" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="address" value="Dirección de residencia" />
        <JetInput
          id="address"
          v-model="form.address"
          type="text"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.address" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="code_phone" value="Código" />
        <Multiselect v-model="form.code_phone" :options="codeTypes" />
        <JetInputError :message="form.errors.code_phone" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="phone" value="Teléfono" />
        <JetInput
          id="phone"
          v-model="form.phone"
          type="number"
          min="0"
          class="mt-1 block w-full"
          autocomplete="off"
        />
        <JetInputError :message="form.errors.phone" class="mt-2" />
      </div>
      <div class="col-span-6 sm:col-span-4">
        <JetLabel for="allow_login" value="Permitir iniciar sesión" />
        <Multiselect v-model="form.allow_login" :options="allowLoginList" />
        <JetInputError :message="form.errors.allow_login" class="mt-2" />
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
