<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import CustomDetailsTable from "@/Components/DetailsTable.vue";
import CustomDetailsTableItem from "@/Components/DetailsTableItem.vue";

defineProps({
  category: {
    type: Object,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  },
});
</script>

<template>
  <AppLayout title="Información de la categoría">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Información de la categoría
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
          <template #title>{{ category.name }}</template>
          <template #subtitle>Información sobre la categoría.</template>
          <template #content>
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="ID"
              :value="category.id"
            />
            <CustomDetailsTableItem
              class="bg-white"
              title="Nombre"
              :value="category.name"
            />
            <CustomDetailsTableItem
              class="bg-gray-100"
              title="Categoría principal"
              :value="category.principal"
            />
          </template>
        </CustomDetailsTable>
      </div>
    </div>
  </AppLayout>
</template>
