<script setup>
import { useSearch } from "@/Composables/useSearch.js";
import Multiselect from "vue-multiselect";

/**
 ** NOTA: formSearch: debe ser una referncia reactiva con 'useForm' de inertiajs, Ejemplo:
 ** const formSearch = useForm({
 **   search: '',
 ** });
 */

const props = defineProps({
  formSearch: {
    required: true,
  },
  formSearchText: {
    type: String,
    required: true,
  },
  placeholderText: {
    type: String,
    required: true,
  },
  groupList: {
    required: true,
  },
  urlSearch: {
    type: String,
    required: true,
  },
});

const { resetSearch } = useSearch(props.formSearch, props.urlSearch);
</script>

<template>
  <div class="flex flex-col md:flex-row">
    <Multiselect
      v-model="formSearch[formSearchText]"
      :options="groupList"
      group-values="items"
      group-label="label"
      :searchable="true"
      track-by="name"
      label="name"
      :placeholder="placeholderText"
      :show-labels="false"
      :showNoOptions="false"
    />
  </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>
