<script setup>
  import JetButton from "@/Jetstream/Button.vue";

  const backHistory = () => {
    /* history.back() */
    history.go(-1);
  }
</script>

<template>
  <JetButton type="button" @click="backHistory">
    Regresar
  </JetButton>
</template>
