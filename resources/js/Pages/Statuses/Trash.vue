<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";

import CustomSearch from "@/Components/Search.vue";
import CustomPagination from "@/Components/Pagination.vue";
import CustomList from "./ListTrash.vue";

const props = defineProps({
  statuses: {
    type: Object,
    required: true,
  },
  urls: {
    type: Object,
    required: true,
  },
  filters: {
    type: Object,
  },
});

const formSearch = useForm({
  search: props.filters.search,
});

const urlSearch = route("statuses.trash");
</script>

<template>
  <AppLayout title="Lista de estados en papelera de reciclaje">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Estados en papelera de reciclaje
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row justify-between pb-2">
          <CustomSearch :formSearch="formSearch" :urlSearch="urlSearch" />
          <div>
            <JetButton type="button">
              <Link :href="urls.return_url">Regresar</Link>
            </JetButton>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <CustomList :statuses="statuses.data" />
        </div>

        <div class="bg-gray-200 overflow-hidden shadow-xl sm:rounded-lg mt-4">
          <div class="flex items-center justify-center">
            <CustomPagination :links="statuses.links" class="py-2" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
