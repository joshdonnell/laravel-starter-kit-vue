<script setup lang="ts">
import type { CollapsibleContentProps } from "reka-ui"
const props = defineProps<CollapsibleContentProps>()
</script>

<template>
  <RekaCollapsibleContent
    data-slot="collapsible-content"
    v-bind="props"
  >
    <slot />
  </RekaCollapsibleContent>
</template>
