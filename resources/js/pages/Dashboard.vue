<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Dashboard',
    href: dashboard().url,
  },
]
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <SharedPlaceholder class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border" />
        <SharedPlaceholder class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border" />
        <SharedPlaceholder class="border-sidebar-border/70 dark:border-sidebar-border relative aspect-video overflow-hidden rounded-xl border" />
      </div>

      <SharedPlaceholder class="border-sidebar-border/70 dark:border-sidebar-border relative min-h-screen flex-1 rounded-xl border md:min-h-min" />
    </div>
  </AppLayout>
</template>
