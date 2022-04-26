<script setup>
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
  item: {
    type: Object,
    requred: true,
  },
});

const { url, name, icon } = props.item;
</script>

<template>
  <div class="p-4">
    <Link :href="url">
      <div
        class="flex justify-center items-center h-40 bg-gray-700 rounded-lg shadow-md cursor-pointer"
      >
        <div class="flex flex-col">
          <div class="text-center py-4 text-6xl text-orange-400">
            <span :class="icon"></span>
          </div>
          <h3 class="text-lg font-semibold text-white">{{ name }}</h3>
        </div>
      </div>
    </Link>
  </div>
</template>
