<script setup lang="ts">
import type { NavigationMenuItem } from '@nuxt/ui'
import { edit as editAppearance } from '@/routes/appearance'
import { edit as editPassword } from '@/routes/password'
import { show as editTwoFactor } from '@/routes/two-factor'
import { edit as editProfile } from '@/routes/user-profile'

const settingsLayoutItems: NavigationMenuItem[][] = [
  [
    {
      label: 'Profile',
      href: editProfile().url,
    },
    {
      label: 'Password',
      href: editPassword().url,
    },
    {
      label: 'Two-Factor Auth',
      href: editTwoFactor().url,
    },
    {
      label: 'Appearance',
      href: editAppearance().url,
    },
  ],
]
</script>

<template>
  <div class="px-4 py-6">
    <SharedHeading
      title="Settings"
      description="Manage your profile and account settings"
    />

    <div class="flex flex-col lg:flex-row lg:space-x-12">
      <aside class="w-full max-w-xl lg:w-48">
        <UNavigationMenu
          :items="settingsLayoutItems"
          orientation="vertical"
        />
      </aside>

      <USeparator class="my-6 lg:hidden" />

      <div class="flex-1 md:max-w-2xl">
        <section class="max-w-xl space-y-12">
          <slot />
        </section>
      </div>
    </div>
  </div>
</template>
