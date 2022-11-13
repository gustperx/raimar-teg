<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";

import CustomSearchGroupList from "@/Components/SearchGroupList.vue";
import CustomSearchSimpleList from "@/Components/SearchSimpleList.vue";
import CustomPagination from "@/Components/Pagination.vue";
import CustomList from "./ListTrash.vue";

const props = defineProps({
  items: {
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

const urlSearch = route("computer-equipments-movements.trash");
</script>

<template>
  <AppLayout
    title="Movimiento de equipos informáticos en papelera de reciclaje"
  >
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Movimiento de equipos informáticos en papelera de reciclaje
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row justify-between pb-2">
          <CustomSearchGroupList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :groupList="equipmentsList"
            formSearchText="equipment_search"
            placeholderText="Buscar por equipo"
            :show-labels="false"
            :showNoOptions="false"
          />
          <CustomSearchGroupList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :groupList="personalList"
            formSearchText="personal_search"
            placeholderText="Buscar por personal"
            :show-labels="false"
            :showNoOptions="false"
          />
          <CustomSearchSimpleList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :simpleList="departmentsList"
            formSearchText="department_search"
            placeholderText="Buscar por departamento"
            :show-labels="false"
            :showNoOptions="false"
          />
          <!-- <CustomSearchSimpleList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :simpleList="statusesList"
            formSearchText="status_search"
            placeholderText="Buscar por estatus"
            :show-labels="false"
            :showNoOptions="false"
          /> -->
          <button
            class="ml-4 font-semibold text-sm text-gray-700 bg-white py-2 px-2 rounded-md"
            @click="formReset"
          >
            Restablecer
          </button>
          <div>
            <JetButton type="button">
              <Link :href="urls.return_url">Regresar</Link>
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
