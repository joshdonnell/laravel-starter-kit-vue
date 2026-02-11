<script setup lang="ts">
import type { NavigationMenuItem } from '@nuxt/ui'
import { useCookies } from '@vueuse/integrations/useCookies'
import { dashboard } from '@/routes'
import type { BreadcrumbItem } from '@/types/navigation'

interface Props {
  breadcrumbs?: BreadcrumbItem[]
}

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
})

const page = usePage()
const sideBarState = useCookies(['sidebar_state'])
const items: NavigationMenuItem[][] = [
  [
    {
      label: 'Platform',
      type: 'label',
    },
    {
      label: 'Dashboard',
      icon: 'i-lucide-layout-grid',
      href: dashboard().url,
    },
  ],
  [
    {
      label: 'Github Repo',
      icon: 'i-lucide-folder',
      to: 'https://github.com/laravel/vue-starter-kit',
      target: '_blank',
    },
    {
      label: 'Documentation',
      icon: 'i-lucide-book-open',
      to: 'https://laravel.com/docs/12.x/starter-kits#vue',
      target: '_blank',
    },
  ],
]
</script>

<template>
  <UDashboardGroup>
    <UDashboardSidebar
      collapsible
      resizable
      :collapsed="page.props.sidebarOpen === false"
      @update:collapsed="
        sideBarState.set('sidebar_state', sideBarState.get('sidebar_state') ? 'false' : 'true', {
          path: '/',
        })
      "
    >
      <template #header="">
        <AppLogo />
      </template>

      <template #default="{ collapsed }">
        <UNavigationMenu
          :collapsed="collapsed"
          :items="items[0]"
          orientation="vertical"
        />

        <UNavigationMenu
          :collapsed="collapsed"
          :items="items[1]"
          orientation="vertical"
          class="mt-auto"
        />
      </template>

      <template #footer="{ collapsed }">
        <UserMenu :collapsed="collapsed" />
      </template>
    </UDashboardSidebar>

    <UDashboardPanel resizable>
      <template #header>
        <UDashboardNavbar :title="breadcrumbs[0]?.title">
          <template #leading>
            <UDashboardSidebarCollapse />
          </template>
        </UDashboardNavbar>
      </template>

      <template #body>
        <slot />
      </template>
    </UDashboardPanel>
  </UDashboardGroup>
</template>
