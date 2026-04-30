<script setup lang="ts">
import type { SelectItemTextProps } from "reka-ui"
const props = defineProps<SelectItemTextProps>()
</script>

<template>
  <RekaSelectItemText
    data-slot="select-item-text"
    v-bind="props"
  >
    <slot />
  </RekaSelectItemText>
</template>
