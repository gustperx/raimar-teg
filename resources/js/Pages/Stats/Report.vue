<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import BarChart from "@/Components/BarChart.vue";

defineProps({
  medicalEquipmentData: {
    type: Object,
    required: true,
  },
  computerEquipmentData: {
    type: Object,
    required: true,
  },
  dMedical: {
    type: Object,
    required: true,
  },
  dComputer: {
    type: Object,
    required: true,
  },
});

const chartOptions = {
  responsive: false,
};
</script>

<template>
  <AppLayout title="Estadísticas">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Estadísticas
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div
          class="mx-auto bg-white overflow-hidden shadow-xl sm:rounded-lg p-8"
        >
          <div class="grid grid-cols-3 gap my-4">
            <div>
              <h3 class="text-2xl font-semibold">Estados de equipos médicos</h3>
              <p class="my-4"></p>
            </div>
            <div class="col-span-2">
              <BarChart
                :chart-options="chartOptions"
                :chart-data="medicalEquipmentData"
              />
            </div>
          </div>
          <div class="grid grid-cols-3 gap my-4">
            <div>
              <h3 class="text-2xl font-semibold">
                Estados de equipos informáticos
              </h3>
              <p class="my-4"></p>
            </div>
            <div class="col-span-2">
              <BarChart
                :chart-options="chartOptions"
                :chart-data="computerEquipmentData"
              />
            </div>
          </div>
          <div class="grid grid-cols-3 gap my-4">
            <div>
              <h3 class="text-2xl font-semibold">
                Distribución de equipos medicos y departamentos
              </h3>
              <p class="my-4"></p>
            </div>
            <div class="col-span-2">
              <BarChart :chart-options="chartOptions" :chart-data="dMedical" />
            </div>
          </div>
          <div class="grid grid-cols-3 gap my-4">
            <div>
              <h3 class="text-2xl font-semibold">
                Distribución de equipos informáticos y departamentos
              </h3>
              <p class="my-4"></p>
            </div>
            <div class="col-span-2">
              <BarChart :chart-options="chartOptions" :chart-data="dComputer" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
