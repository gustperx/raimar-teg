<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";

import CustomSearchGroupList from "@/Components/SearchGroupList.vue";
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
  equipmentsList: {
    type: Array,
    requered: true,
  },
  personalList: {
    type: Array,
    requered: true,
  },
  statusesList: {
    type: Array,
    requered: true,
  },
  departmentsList: {
    type: Array,
    requered: true,
  },
});

const formSearch = useForm({
  equipment_search: props.filters.equipment_search.equipment_search,
  personal_search: props.filters.personal_search.personal_search,
  department_search: props.filters.department_search.department_search,
  status_search: props.filters.status_search.status_search,
});

const formReset = () => {
  formSearch.equipment_search = null;
  formSearch.personal_search = null;
  formSearch.department_search = null;
  formSearch.status_search = null;
};

const urlSearch = route("computer-equipments-movements.index");
</script>

<template>
  <AppLayout title="Movimiento de equipos informáticos">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Movimiento de equipos informáticos
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row justify-between pb-2">
          <CustomSearchGroupList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :groupList="equipmentsList"
            formSearchText="equipment_search"
            placeholderText="Buscar por equipo"
          />
          <CustomSearchGroupList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :groupList="personalList"
            formSearchText="personal_search"
            placeholderText="Buscar por personal"
          />
          <CustomSearchSimpleList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :simpleList="departmentsList"
            formSearchText="department_search"
            placeholderText="Buscar por departamento"
          />
          <CustomSearchSimpleList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :simpleList="statusesList"
            formSearchText="status_search"
            placeholderText="Buscar por estatus"
          />
          <button
            class="ml-4 font-semibold text-sm text-gray-600"
            @click="formReset"
          >
            Restablecer
          </button>
          <div>
            <JetButton type="button" v-if="can.restore" class="mr-2">
              <Link :href="urls.restore_url">Elementos eliminados</Link>
            </JetButton>
            <JetButton type="button" v-if="can.create">
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
