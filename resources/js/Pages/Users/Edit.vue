<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomForm from "./Form.vue";

const props = defineProps({
  userd: {
    type: Object,
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
  return_url: {
    type: String,
    required: true,
  },
  codeTypes: {
    type: Array,
    required: true,
  },
});

const form = useForm({
  name: props.userd.name,
  email: props.userd.email,
  dni: props.userd.dni,
  allow_login: props.userd.allow_login,
  department_id: props.userd.department_id,
  dni_type: props.userd.dni_type,
  address: props.userd.address,
  phone: props.userd.phone,
  gender: props.userd.gender,
  code_phone: props.userd.code_phone,
});

const handleUpdate = () => {
  form.put(route("users.update", [props.userd.id]), {
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
          :allowLoginList="allowLoginList"
          :dniTypes="dniTypes"
          :genderTypes="genderTypes"
          :codeTypes="codeTypes"
        />
      </div>
    </div>
  </AppLayout>
</template>
