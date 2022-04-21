<script setup>
import { useSearch } from "@/Composables/useSearch.js";
import JetInput from "@/Jetstream/Input.vue";

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
  urlSearch: {
    type: String,
    required: true,
  },
});

const { resetSearch } = useSearch(props.formSearch, props.urlSearch);
</script>

<template>
  <div class="flex flex-col md:flex-row">
    <JetInput
      id="search"
      v-model="formSearch.search"
      type="text"
      class="inline w-full"
      placeholder="Buscar..."
      autocomplete="off"
    />
    <button
      class="ml-4 font-semibold text-sm text-gray-600"
      @click="resetSearch"
    >
      Restablecer
    </button>
  </div>
</template>
