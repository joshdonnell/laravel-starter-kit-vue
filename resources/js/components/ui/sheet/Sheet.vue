<script setup lang="ts">
import type { DialogRootEmits, DialogRootProps } from "reka-ui"
const props = defineProps<DialogRootProps>()
const emits = defineEmits<DialogRootEmits>()

const forwarded = useForwardPropsEmits(props, emits)
</script>

<template>
  <RekaDialogRoot
    v-slot="slotProps"
    data-slot="sheet"
    v-bind="forwarded"
  >
    <slot v-bind="slotProps" />
  </RekaDialogRoot>
</template>
