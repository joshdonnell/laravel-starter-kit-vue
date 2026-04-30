<script setup lang="ts">
import { BookOpen, FolderGit2, LayoutGrid } from 'lucide-vue-next'
import { dashboard } from '@/routes'
import type { NavItem } from '@/types'

const mainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: dashboard(),
    icon: LayoutGrid,
  },
]

const footerNavItems: NavItem[] = [
  {
    title: 'Repository',
    href: 'https://github.com/laravel/vue-starter-kit',
    icon: FolderGit2,
  },
  {
    title: 'Documentation',
    href: 'https://laravel.com/docs/starter-kits#vue',
    icon: BookOpen,
  },
]
</script>

<template>
  <UiSidebar collapsible="icon" variant="inset">
    <UiSidebarHeader>
      <UiSidebarMenu>
        <UiSidebarMenuItem>
          <UiSidebarMenuButton size="lg" as-child>
            <Link :href="dashboard()">
              <AppLogo />
            </Link>
          </UiSidebarMenuButton>
        </UiSidebarMenuItem>
      </UiSidebarMenu>
    </UiSidebarHeader>

    <UiSidebarContent>
      <NavMain :items="mainNavItems" />
    </UiSidebarContent>

    <UiSidebarFooter>
      <NavFooter :items="footerNavItems" />
      <NavUser />
    </UiSidebarFooter>
  </UiSidebar>
  <slot />
</template>
