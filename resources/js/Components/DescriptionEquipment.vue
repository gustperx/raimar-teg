<script setup>

defineProps({
  text: {
    type: String,
    required: false,
  },
  serial: {
    type: String,
    required: true,
  },
  code: {
    type: String,
    required: true,
  },
})

</script>

<template>
  <ul class="text-sm">
    <li>{{ text }}</li>
    <li><span class="font-semibold">Código:</span> {{ code }}</li>
    <li><span class="font-semibold">Serial:</span> {{ serial }}</li>
  </ul>
</template>