<script setup>
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
  item: {
    type: Object,
    requred: true,
  },
});

const { url, name, icon, native = false } = props.item;
</script>

<template>
  <div class="p-4">
    <a :href="url" v-if="native">
      <div
        class="flex justify-center items-center h-48 bg-gray-700 rounded-lg shadow-md cursor-pointer"
      >
        <div class="flex flex-col">
          <div class="text-center py-4 text-6xl text-blue-500">
            <span :class="icon"></span>
          </div>
          <h3 class="text-lg font-semibold text-white text-center">
            {{ name }}
          </h3>
        </div>
      </div>
    </a>
    <Link :href="url" v-else>
      <div
        class="flex justify-center items-center h-48 bg-gray-700 rounded-lg shadow-md cursor-pointer"
      >
        <div class="flex flex-col">
          <div class="text-center py-4 text-6xl text-blue-500">
            <span :class="icon"></span>
          </div>
          <h3 class="text-lg font-semibold text-white text-center">
            {{ name }}
          </h3>
        </div>
      </div>
    </Link>
  </div>
</template>
