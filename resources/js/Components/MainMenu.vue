<script setup>
import { computed } from "vue";
import MainMenuItem from "./MainMenuItem.vue";

const props = defineProps({
  menu: {
    type: Array,
    requred: true,
  },
});

const activeMenu = computed(() => props.menu.filter((item) => item.access));
</script>

<template>
  <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
    <MainMenuItem v-for="item in activeMenu" :item="item" :key="item.url" />
  </div>
</template>
