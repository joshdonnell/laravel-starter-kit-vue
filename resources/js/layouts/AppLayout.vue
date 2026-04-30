<script setup lang="ts">
import type { BreadcrumbItem } from '@/types'

type Props = {
  breadcrumbs?: BreadcrumbItem[]
}

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
})
</script>

<template>
  <AppSidebarLayout :breadcrumbs="breadcrumbs">
    <slot />
  </AppSidebarLayout>
</template>
