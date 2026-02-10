<script setup lang="ts">
import { edit as editAppearance } from '@/wayfinder/routes/appearance'
import { show } from '@/wayfinder/routes/two-factor'
import { type NavItem } from '@/types'
import { toUrl, urlIsActive } from '@/utils/inertia'
import { Link } from '@inertiajs/vue3'

const sidebarNavItems: NavItem[] = [
  // {
  //   title: 'Profile',
  //   href: editProfile(),
  // },
  // {
  //   title: 'Password',
  //   href: editPassword(),
  // },
  {
    title: 'Two-Factor Auth',
    href: show(),
  },
  {
    title: 'Appearance',
    href: editAppearance(),
  },
]

const currentPath = typeof window !== undefined ? window.location.pathname : ''
</script>

<template>
  <div class="px-4 py-6">
    <!--    <Heading-->
    <!--      title="Settings"-->
    <!--      description="Manage your profile and account settings"-->
    <!--    />-->

    <div class="flex flex-col lg:flex-row lg:space-x-12">
      <aside class="w-full max-w-xl lg:w-48">
        <nav class="flex flex-col space-y-1 space-x-0">
          <Button
            v-for="item in sidebarNavItems"
            :key="toUrl(item.href)"
            variant="ghost"
            :class="['w-full justify-start', { 'bg-muted': urlIsActive(item.href, currentPath) }]"
            as-child
          >
            <Link :href="item.href">
              <component
                :is="item.icon"
                class="h-4 w-4"
              />
              {{ item.title }}
            </Link>
          </Button>
        </nav>
      </aside>

      <Separator class="my-6 lg:hidden" />

      <div class="flex-1 md:max-w-2xl">
        <section class="max-w-xl space-y-12">
          <slot />
        </section>
      </div>
    </div>
  </div>
</template>
