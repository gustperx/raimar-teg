<script setup>
import VueBarcode from '@chenfengyuan/vue-barcode';

defineProps({
  code: {
    type: String,
    required: true
  }
})

</script>

<template>
  <VueBarcode 
    :value="code" 
    :options="{ displayValue: true, format: 'CODE39', width: 1, height: 50, fontSize: 10, margin: 0, text: `*${code}*` }"
  ></VueBarcode>
</template>