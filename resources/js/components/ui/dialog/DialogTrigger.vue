<script setup lang="ts">
import type { DialogTriggerProps } from "reka-ui"
const props = defineProps<DialogTriggerProps>()
</script>

<template>
  <RekaDialogTrigger
    data-slot="dialog-trigger"
    v-bind="props"
  >
    <slot />
  </RekaDialogTrigger>
</template>
