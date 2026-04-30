<script setup lang="ts">
import type { CollapsibleTriggerProps } from "reka-ui"
const props = defineProps<CollapsibleTriggerProps>()
</script>

<template>
  <RekaCollapsibleTrigger
    data-slot="collapsible-trigger"
    v-bind="props"
  >
    <slot />
  </RekaCollapsibleTrigger>
</template>
