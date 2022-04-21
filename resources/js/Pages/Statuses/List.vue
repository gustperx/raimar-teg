<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import TableList from "@/Components/TableList.vue";
import ButtonBlue from "@/Components/ButtonBlue.vue";
import ButtonRed from "@/Components/ButtonRed.vue";

defineProps({
    statuses: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <TableList>
        <template #header>
            <tr class="bg-gray-600">
                <th class="text-left text-white p-4 font-bold">ID</th>
                <th class="text-left text-white p-4 font-bold">Nombre</th>
                <th class="text-left text-white p-4 font-bold"></th>
            </tr>
        </template>

        <template #body>
            <tr
                v-for="{ id, name, edit_url, can } in statuses"
                :key="id"
                class="border-b hover:bg-gray-50"
            >
                <td class="p-4">{{ id }}</td>
                <td class="p-4">{{ name }}</td>
                <td>
                    <div class="flex flex-col md:flex-row">
                        <ButtonBlue v-if="can.edit">
                            <Link :href="edit_url">Editar</Link>
                        </ButtonBlue>
                        <ButtonRed v-if="can.delete">
                            <Link href="dell">Eliminar</Link>
                        </ButtonRed>
                    </div>
                </td>
            </tr>
        </template>
    </TableList>
</template>
7
