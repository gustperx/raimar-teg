<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import MainMenuItem from "./MainMenuItem.vue";
import HistoryBack from "./HistoryBack.vue";

const props = defineProps({
  menu: {
    type: Array,
    requred: true,
  },
  activeBack: {
    type: Boolean,
    required: true,
  },
  return_url: {
    type: String,
    required: true,
  }
});

const activeMenu = computed(() => props.menu.filter((item) => item.access));
</script>

<template>
  <div v-if="activeBack" class="flex flex-row-reverse">
    <JetButton type="button">
      <Link :href="return_url">Regresar</Link>
    </JetButton>
  </div>
  <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
    <MainMenuItem v-for="item in activeMenu" :item="item" :key="item.url" />
  </div>
</template>
