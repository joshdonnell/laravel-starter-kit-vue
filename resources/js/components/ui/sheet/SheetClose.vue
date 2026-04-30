<script setup lang="ts">
import type { DialogCloseProps } from "reka-ui"
const props = defineProps<DialogCloseProps>()
</script>

<template>
  <RekaDialogClose
    data-slot="sheet-close"
    v-bind="props"
  >
    <slot />
  </RekaDialogClose>
</template>
