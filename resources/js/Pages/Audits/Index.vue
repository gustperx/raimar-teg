<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";

import CustomSearchSimpleList from "@/Components/SearchSimpleList.vue";
import CustomSearchGroupList from "@/Components/SearchGroupList.vue";
import CustomPagination from "@/Components/Pagination.vue";
import CustomList from "./List.vue";

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

const formSearch = useForm({
  by_user: props.filters.by_user.by_user,
  by_module: props.filters.by_module.by_module,
});

const formReset = () => {
  formSearch.by_user = null;
  formSearch.by_module = null;
};

const urlSearch = route("audits.index");

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
