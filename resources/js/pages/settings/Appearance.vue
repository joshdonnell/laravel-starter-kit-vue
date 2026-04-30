<script setup lang="ts">
import { edit } from '@/routes/appearance'
import type { BreadcrumbItem } from '@/types'

const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: 'Appearance settings',
    href: edit(),
  },
]
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head title="Appearance settings" />

    <h1 class="sr-only">Appearance settings</h1>

    <SettingsLayout>
      <div class="space-y-6">
        <Heading
          variant="small"
          title="Appearance settings"
          description="Update your account's appearance settings"
        />
        <AppearanceTabs />
      </div>
    </SettingsLayout>
  </AppLayout>
</template>
