<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetButton from "@/Jetstream/Button.vue";
import List from "./List.vue";

defineProps({
    statuses: {
        type: Array,
        required: true,
    },
    create_url: {
        type: String,
        required: true,
    },
    can: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AppLayout title="Statuses">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Estados de equipos
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-row justify-between pb-2">
                    <div></div>
                    <div>
                        <JetButton type="button" v-if="can.create">
                            <Link :href="create_url">Nuevo estado</Link>
                        </JetButton>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <List :statuses="statuses" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>
