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
  <div class="grid grid-cols-4 gap-4">
    <MainMenuItem v-for="item in activeMenu" :item="item" :key="item.url" />
  </div>
</template>
