<script setup lang="ts">
import type { DropdownMenuItem } from '@nuxt/ui'
import { logout } from '@/routes'
import profile from '@/routes/user-profile'

defineProps<{
  collapsed?: boolean
}>()

const page = usePage()
const user = page.props.auth.user

const items = computed<DropdownMenuItem[]>(() => [
  [
    {
      type: 'label',
      label: user?.name,
      avatar: null,
    },
  ],
  [
    {
      label: 'Settings',
      icon: 'i-lucide-settings',
      to: profile.edit().url,
    },
  ],
  [
    {
      label: 'Log out',
      icon: 'i-lucide-log-out',
      onSelect: () => {
        router.visit(logout().url, {
          method: logout().method,
        })
      },
    },
  ],
])
</script>

<template>
  <UDropdownMenu
    :items="items"
    :content="{ align: 'center', collisionPadding: 12 }"
    :ui="{ content: collapsed ? 'w-48' : 'w-(--reka-dropdown-menu-trigger-width)' }"
  >
    <UButton
      v-bind="{
        user: user,
        label: collapsed ? undefined : user?.name,
        trailingIcon: collapsed ? undefined : 'i-lucide-chevrons-up-down',
      }"
      color="neutral"
      variant="ghost"
      block
      :square="collapsed"
      class="data-[state=open]:bg-elevated"
    />
  </UDropdownMenu>
</template>
