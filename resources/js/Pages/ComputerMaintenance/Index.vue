<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";

import CustomSearchSimpleList from "@/Components/SearchSimpleList.vue";
import CustomPagination from "@/Components/Pagination.vue";
import CustomList from "./List.vue";

const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
  urls: {
    type: Object,
    required: true,
  },
  can: {
    type: Object,
    required: true,
  },
  filters: {
    type: Object,
  },
  statusesList: {
    type: Array,
    requered: true,
  },
});

const formSearch = useForm({
  status_search: props.filters.status_search.status_search,
});

const formReset = () => {
  formSearch.status_search = null;
};

const urlSearch = route("computer-maintenance.index");
</script>

<template>
  <AppLayout title="Mantenimiento de equipos de cómputo">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Mantenimiento de equipos de cómputo
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row justify-between pb-2">
          <!-- <CustomSearchSimpleList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :simpleList="statusesList"
            formSearchText="status_search"
            placeholderText="Buscar por estatus"
            :show-labels="false"
            :showNoOptions="false"
          />
          <button
            class="ml-4 font-semibold text-sm text-gray-600"
            @click="formReset"
          >
            Restablecer
          </button> -->
          <div></div>
          <div>
            <JetButton type="button">
              <Link href="/dashboard/informatica">Regresar</Link>
            </JetButton>
            <JetButton type="button" v-if="can.create" class="ml-2">
              <Link :href="urls.create_url">Nuevo elemento</Link>
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
