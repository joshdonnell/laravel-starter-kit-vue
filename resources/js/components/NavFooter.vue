<script setup lang="ts">
import { toUrl } from '@/lib/utils'
import type { NavItem } from '@/types'

type Props = {
  items: NavItem[]
  class?: string
}

defineProps<Props>()
</script>

<template>
  <UiSidebarGroup
    :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`"
  >
    <UiSidebarGroupContent>
      <UiSidebarMenu>
        <UiSidebarMenuItem v-for="item in items" :key="item.title">
          <UiSidebarMenuButton
            class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100"
            as-child
          >
            <a
              :href="toUrl(item.href)"
              target="_blank"
              rel="noopener noreferrer"
            >
              <component :is="item.icon" />
              <span>{{ item.title }}</span>
            </a>
          </UiSidebarMenuButton>
        </UiSidebarMenuItem>
      </UiSidebarMenu>
    </UiSidebarGroupContent>
  </UiSidebarGroup>
</template>
