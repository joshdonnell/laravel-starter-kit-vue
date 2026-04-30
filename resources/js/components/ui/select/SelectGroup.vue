<script setup lang="ts">
import type { SelectGroupProps } from "reka-ui"
const props = defineProps<SelectGroupProps>()
</script>

<template>
  <RekaSelectGroup
    data-slot="select-group"
    v-bind="props"
  >
    <slot />
  </RekaSelectGroup>
</template>
