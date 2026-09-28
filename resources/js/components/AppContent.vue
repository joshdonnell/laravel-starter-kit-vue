<script setup lang="ts">
import type { AppVariant } from '@/types'

const props = withDefaults(
  defineProps<{
    variant?: AppVariant
    class?: string
  }>(),
  {
    variant: 'sidebar',
  },
)
</script>

<template>
  <UiSidebarInset v-if="props.variant === 'sidebar'" :class="props.class">
    <slot />
  </UiSidebarInset>
  <main
    v-else
    class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl"
    :class="props.class"
  >
    <slot />
  </main>
</template>
