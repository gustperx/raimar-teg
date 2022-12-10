<script setup>
import { ref, onMounted } from 'vue';
import { Link, useForm } from "@inertiajs/inertia-vue3";

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import { es } from "date-fns/locale";

import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";

import CustomSearchSimpleList from "@/Components/SearchSimpleList.vue";
import CustomSearchGroupList from "@/Components/SearchGroupList.vue";
import CustomPagination from "@/Components/Pagination.vue";
import CustomList from "./List.vue";

import { formatDate, transforDate } from "@/Utils/format-date";

const props = defineProps({
  items: {
    type: Object,
    required: true,
  },
  filters: {
    type: Object,
  },
  users: {
    type: Array,
    requered: true,
  },
  modules: {
    type: Object,
    requered: true,
  },
});

const { startDate: dateA, endDate: dateB } = JSON.parse(props.filters.by_range);
const formSearch = useForm({
  by_user: props.filters.by_user.by_user,
  by_module: props.filters.by_module.by_module,
  by_month: props.filters.by_month.by_month,
  by_range: { startDate: transforDate(dateA), endDate: transforDate(dateB) }
});

const formReset = () => {
  formSearch.by_user = null;
  formSearch.by_module = null;
  formSearch.by_month = null;
  formSearch.by_range = null;
};

const urlSearch = route("audits.index");

const date = ref();

// For demo purposes assign range from the current date
onMounted(() => {
    const startDate = transforDate(dateA);
    const endDate = transforDate(dateB);
    date.value = [startDate, endDate];
})

const handleSearchDate = () => {

  const [seletedStartDate, seletedEndDate] = date.value
  const startDate = formatDate(seletedStartDate)
  const endDate = formatDate(seletedEndDate)
  
  formSearch.by_range = { startDate, endDate }

  formSearch.get(urlSearch, formSearch, {
    preserveState: true,
  });
};

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
          <CustomSearchGroupList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :groupList="users"
            formSearchText="by_user"
            placeholderText="Buscar por usuario"
            :show-labels="false"
            :showNoOptions="false"
          />
          <CustomSearchSimpleList
            :formSearch="formSearch"
            :urlSearch="urlSearch"
            :simpleList="modules"
            formSearchText="by_module"
            placeholderText="Buscar por modulo"
            :show-labels="false"
            :showNoOptions="false"
          />
          <!-- <div>
            <input
              type="month"
              v-model="formSearch.by_month"
              class="input mt-1 block"
              @input="handleSearchDate"
            />
          </div> -->
          <div>
            <Datepicker 
              v-model="date" 
              :format-locale="es"
              :enable-time-picker="false" 
              format="dd/MM/yyyy" 
              range 
              locale="es" cancelText="Cancelar" selectText="Seleccionar"
              class="input mt-1 block"
              @update:model-value="handleSearchDate"
            />
          </div>
          <button
            class="ml-4 font-semibold text-sm text-gray-700 bg-white py-2 px-2 rounded-md"
            @click="formReset"
          >
            Restablecer
          </button>
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
