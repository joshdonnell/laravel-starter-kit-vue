<script setup lang="ts">
import type { SelectValueProps } from "reka-ui"
const props = defineProps<SelectValueProps>()
</script>

<template>
  <RekaSelectValue
    data-slot="select-value"
    v-bind="props"
  >
    <slot />
  </RekaSelectValue>
</template>
