<script setup lang="ts">
import type { DropdownMenuTriggerProps } from "reka-ui"
const props = defineProps<DropdownMenuTriggerProps>()

const forwardedProps = useForwardProps(props)
</script>

<template>
  <RekaDropdownMenuTrigger
    data-slot="dropdown-menu-trigger"
    v-bind="forwardedProps"
  >
    <slot />
  </RekaDropdownMenuTrigger>
</template>
