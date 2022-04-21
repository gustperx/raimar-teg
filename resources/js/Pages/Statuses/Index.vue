<script setup>
import { Link, useForm } from "@inertiajs/inertia-vue3";

import { useSearch } from "@/Composables/useSearch.js";

import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import List from "./List.vue";

const props = defineProps({
  statuses: {
    type: Array,
    required: true,
  },
  create_url: {
    type: String,
    required: true,
  },
  can: {
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

const { resetSearch } = useSearch(formSearch, route("statuses.index"));
</script>

<template>
  <AppLayout title="Statuses">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Estados de equipos
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="flex flex-row justify-between pb-2">
          <div class="flex">
            <JetInput
              id="search"
              v-model="formSearch.search"
              type="text"
              class="inline w-full"
              placeholder="Buscar..."
              autocomplete="off"
            />
            <button class="ml-4 text-bold text-gray-600" @click="resetSearch">
              Restablecer
            </button>
          </div>
          <div>
            <JetButton type="button" v-if="can.create">
              <Link :href="create_url">Nuevo estado</Link>
            </JetButton>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <List :statuses="statuses" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>
