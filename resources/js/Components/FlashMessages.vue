<script setup>
import { ref } from "vue";
import CheckIcon from "./icons/CheckIcon.vue";
import RefreshIcon from "./icons/RefreshIcon.vue";
import ErrorIcon from "./icons/ErrorIcon.vue";
import ExclamationIcon from "./icons/ExclamationIcon.vue";

const show = ref(true);
</script>

<template>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div
      v-if="$page.props.flash_message.success && show"
      class="w-full bg-green-200 mx-auto mt-4 p-2"
    >
      <div class="flex justify-between">
        <div class="flex space-x-2">
          <CheckIcon class="text-green-900" />
          <p class="text-green-900 font-semibold">
            {{ $page.props.flash_message.success }}
          </p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
          <button @click="show = false">
            <span class="sr-only">Close</span>
            <ErrorIcon class="text-green-900" />
          </button>
        </div>
      </div>
    </div>

    <div
      v-if="$page.props.flash_message.info && show"
      class="w-full bg-blue-200 mx-auto mt-4 p-2"
    >
      <div class="flex justify-between">
        <div class="flex space-x-2">
          <RefreshIcon class="text-blue-900" />
          <p class="text-blue-900 font-semibold">
            {{ $page.props.flash_message.info }}
          </p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
          <button @click="show = false">
            <span class="sr-only">Close</span>
            <ErrorIcon class="text-blue-900" />
          </button>
        </div>
      </div>
    </div>

    <div
      v-if="$page.props.flash_message.error && show"
      class="w-full bg-red-200 mx-auto mt-4 p-2"
    >
      <div class="flex justify-between">
        <div class="flex space-x-2">
          <ErrorIcon class="text-red-900" />
          <p class="text-red-900 font-semibold">
            {{ $page.props.flash_message.error }}
          </p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
          <button @click="show = false">
            <span class="sr-only">Close</span>
            <ErrorIcon class="text-red-900" />
          </button>
        </div>
      </div>
    </div>

    <div
      v-if="$page.props.flash_message.warn && show"
      class="w-full bg-amber-200 mx-auto mt-4 p-2"
    >
      <div class="flex justify-between">
        <div class="flex space-x-2">
          <ExclamationIcon class="text-amber-900" />
          <p class="text-amber-900 font-semibold">
            {{ $page.props.flash_message.warn }}
          </p>
        </div>
        <div class="ml-4 flex-shrink-0 flex">
          <button @click="show = false">
            <span class="sr-only">Close</span>
            <ErrorIcon class="text-amber-900" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
