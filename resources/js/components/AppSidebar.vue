<script setup lang="ts">
import { extraNavItems, mainNavItems } from '@/lib/navigation'
import { dashboard } from '@/routes'
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
      <NavFooter :items="extraNavItems" />
      <NavUser />
    </UiSidebarFooter>
  </UiSidebar>
</template>
