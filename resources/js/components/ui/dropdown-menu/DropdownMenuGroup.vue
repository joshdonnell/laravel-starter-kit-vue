<script setup lang="ts">
import type { DropdownMenuGroupProps } from "reka-ui"
const props = defineProps<DropdownMenuGroupProps>()
</script>

<template>
  <RekaDropdownMenuGroup
    data-slot="dropdown-menu-group"
    v-bind="props"
  >
    <slot />
  </RekaDropdownMenuGroup>
</template>
