<script setup lang="ts">
import type { TooltipTriggerProps } from "reka-ui"
const props = defineProps<TooltipTriggerProps>()
</script>

<template>
  <RekaTooltipTrigger
    data-slot="tooltip-trigger"
    v-bind="props"
  >
    <slot />
  </RekaTooltipTrigger>
</template>
