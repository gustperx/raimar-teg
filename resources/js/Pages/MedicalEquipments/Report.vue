<script setup>
import { onMounted } from "vue";
import { Printd } from "printd";
import BarCode from "@/Components/BarCode.vue";
import CustomTableList from "@/Components/TableList.vue";
import StatusColor from "@/Components/StatusColor.vue";
import DescriptionEquipment from "@/Components/DescriptionEquipment.vue";

defineProps({
  items: {
    type: Object,
    required: true,
  },
});

const d = new Printd();
const styles = [
  '/css/app.css'
];

onMounted(() => d.print( document.getElementById('print-div'), styles ));

</script>

<template>
  <div class="py-12" id="print-div">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      <div class="flex justify-between">
        <div class="text-2xl font-bold text-blue-800">
          Equipos médicos
        </div>
        <div>
          <img src="/img/cli_lug.png" class="w-20 -mb-8" alt="cli_lig" />
        </div>
      </div>

      <div class="flex justify-between mb-20">
        <div class="text-lg font-bold">
          <span class="text-blue-800">Generado por: </span> {{ $page.props.user.name }}
        </div>
      </div>

      <CustomTableList>
        <template #header>
          <tr class="bg-gray-600">
            <th class="text-left text-white p-2 font-bold">ID</th>
            <th class="text-left text-white p-2 font-bold">Categoría</th>
            <th class="text-left text-white p-2 font-bold">Descripción</th>
            <th class="text-left text-white p-2 font-bold">Departamento</th>
            <th class="text-left text-white p-2 font-bold">Estatus</th>
            <!-- <th class="text-left text-white p-2 font-bold">Código de barra</th>
            <th class="text-left text-white p-2 font-bold">Actualización</th> -->
          </tr>
        </template>

        <template #body>
          <tr
            v-for="{
              id,
              description,
              code,
              serial,
              category,
              status,
              status_color,
              department,
              updated_at,
            } in items.data"
            :key="id"
            class="border-b hover:bg-gray-50"
          >
            <td class="p-2">{{ id }}</td>
            <td class="p-2">{{ category }}</td>
            <td class="p-2">
              <DescriptionEquipment
                :text="description"
                :code="code"
                :serial="serial"
              />
            </td>
            <td class="p-2">{{ department }}</td>
            <td class="p-2">
              <!-- <StatusColor :color="status_color" :text="status" /> -->
              {{ status }}
            </td>
            <!-- <td class="p-2">
              <BarCode :code="code" />
            </td>
            <td class="p-2">{{ updated_at }}</td> -->
          </tr>
        </template>
      </CustomTableList>
    </div>
  </div>
</template>
