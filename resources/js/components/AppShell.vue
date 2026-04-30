<script setup lang="ts">
import type { AppVariant } from '@/types'

type Props = {
  variant?: AppVariant
}

withDefaults(defineProps<Props>(), {
  variant: 'sidebar',
})

const isOpen = usePage().props.sidebarOpen
</script>

<template>
  <div v-if="variant === 'header'" class="flex min-h-screen w-full flex-col">
    <slot />
  </div>
  <UiSidebarProvider v-else :default-open="isOpen">
    <slot />
  </UiSidebarProvider>
</template>
