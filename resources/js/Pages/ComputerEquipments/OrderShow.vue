<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomDetailsTable from "@/Components/DetailsTable.vue";
import CustomDetailsTableItem from "@/Components/DetailsTableItem.vue";

defineProps({
  equipment: {
    type: Object,
    required: true,
  },
  user: {
    type: Object,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  },
  approve_url: {
    type: String,
    required: true,
  },
  decline_url: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <AppLayout title="Información del equipo de cómputo">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Información del pedido
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row justify-between pb-2">
          <div></div>
          <div>
            <JetButton type="button" class="mr-2">
              <Link :href="return_url">Regresar</Link>
            </JetButton>
            <JetButton type="button" class="mr-2">
              <Link :href="decline_url">Rechazar</Link>
            </JetButton>
            <JetButton type="button">
              <Link :href="approve_url">Aprobar</Link>
            </JetButton>
          </div>
        </div>

        <CustomDetailsTable>
          <template #title>{{ user.name }}</template>
          <template #subtitle>Información sobre el usuario.</template>
          <template #content>
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="ID"
              :value="user.id"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Nombre"
              :value="user.name"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Correo electrónico"
              :value="user.email"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Documento de identidad"
              :value="user.dni"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Departamento"
              :value="user.department"
            />
          </template>
        </CustomDetailsTable>

        <div class="my-8"></div>

        <CustomDetailsTable>
          <template #title>{{ equipment.description }}</template>
          <template #subtitle>Información sobre el equipo de cómputo.</template>
          <template #content>
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="ID"
              :value="equipment.id"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Descripción"
              :value="equipment.description"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Código"
              :value="equipment.code"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Serial"
              :value="equipment.serial"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Categoría"
              :value="equipment.category"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Estatus"
              :value="equipment.status"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Marca"
              :value="equipment.brand"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Modelo"
              :value="equipment.model"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Departamento"
              :value="equipment.department"
            />
          </template>
        </CustomDetailsTable>
      </div>
    </div>
  </AppLayout>
</template>
