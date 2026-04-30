<script setup lang="ts">
import type { BreadcrumbItem as BreadcrumbItemType } from '@/types'

type Props = {
  breadcrumbs: BreadcrumbItemType[]
}

defineProps<Props>()
</script>

<template>
  <UiBreadcrumb>
    <UiBreadcrumbList>
      <template v-for="(item, index) in breadcrumbs" :key="index">
        <UiBreadcrumbItem>
          <template v-if="index === breadcrumbs.length - 1">
            <UiBreadcrumbPage>{{ item.title }}</UiBreadcrumbPage>
          </template>
          <template v-else>
            <UiBreadcrumbLink as-child>
              <Link :href="item.href">{{ item.title }}</Link>
            </UiBreadcrumbLink>
          </template>
        </UiBreadcrumbItem>
        <UiBreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" />
      </template>
    </UiBreadcrumbList>
  </UiBreadcrumb>
</template>
