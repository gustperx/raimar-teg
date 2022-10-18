<script setup>
import { Link } from "@inertiajs/inertia-vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";

import CustomPagination from "@/Components/Pagination.vue";
import CustomList from "./List.vue";

const props = defineProps({
  items: {
    type: Object,
    required: true,
  }
});

</script>

<template>
  <AppLayout title="Auditoria">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Auditoria
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row justify-between pb-2">
          <div></div>
          <div>
            <JetButton type="button">
              <Link href="/dashboard">Regresar</Link>
            </JetButton>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <CustomList :items="items.data" />
        </div>

        <div class="bg-gray-200 overflow-hidden shadow-xl sm:rounded-lg mt-4">
          <div class="flex items-center justify-center">
            <CustomPagination :links="items.links" class="py-2" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
