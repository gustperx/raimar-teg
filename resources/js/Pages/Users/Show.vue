<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomDetailsTable from "@/Components/DetailsTable.vue";
import CustomDetailsTableItem from "@/Components/DetailsTableItem.vue";

const props = defineProps({
  userd: {
    type: Object,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  },
});

const allowText = props.userd.allow_login ? "Si" : "No";
</script>

<template>
  <AppLayout title="Información del usuario">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Información del usuario
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

        <CustomDetailsTable>
          <template #title>{{ userd.name }}</template>
          <template #subtitle>Información sobre el usuario.</template>
          <template #content>
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="ID"
              :value="userd.id"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Nombre"
              :value="userd.name"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Correo electrónico"
              :value="userd.email"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Documento de identidad"
              :value="userd.dni"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Departamento"
              :value="userd.department"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Permitir iniciar sesión"
              :value="allowText"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Tipo"
              :value="userd.dni_type"
            />
          </template>
        </CustomDetailsTable>
      </div>
    </div>
  </AppLayout>
</template>
