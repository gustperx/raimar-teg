<script setup>

defineProps({
  color: {
    type: String,
    required: true,
  },
  text: {
    type: String,
    required: false,
  }
})

</script>

<template>
  <span>
    <i class="fa-solid fa-circle" :style="`color: ${color}`"></i> {{ text }}
  </span>
</template>