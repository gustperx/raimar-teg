<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import MainMenu from "../Components/MainMenu.vue";

defineProps({
  menu: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inicio</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <MainMenu :menu="menu" />
      </div>
    </div>
  </AppLayout>
</template>
