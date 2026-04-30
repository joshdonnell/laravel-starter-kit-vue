<script setup lang="ts">
import { BookOpen, Folder, LayoutGrid, Menu, Search } from 'lucide-vue-next'
import { toUrl } from '@/lib/utils'
import { dashboard } from '@/routes'
import type { BreadcrumbItem, NavItem } from '@/types'

type Props = {
  breadcrumbs?: BreadcrumbItem[]
}

const props = withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
})

const page = usePage()
const auth = computed(() => page.props.auth)
const { isCurrentUrl, whenCurrentUrl } = useCurrentUrl()

const activeItemStyles =
  'text-neutral-900 dark:bg-neutral-800 dark:text-neutral-100'

const mainNavItems: NavItem[] = [
  {
    title: 'Dashboard',
    href: dashboard(),
    icon: LayoutGrid,
  },
]

const rightNavItems: NavItem[] = [
  {
    title: 'Repository',
    href: 'https://github.com/laravel/vue-starter-kit',
    icon: Folder,
  },
  {
    title: 'Documentation',
    href: 'https://laravel.com/docs/starter-kits#vue',
    icon: BookOpen,
  },
]
</script>

<template>
  <div>
    <div class="border-b border-sidebar-border/80">
      <div class="mx-auto flex h-16 items-center px-4 md:max-w-7xl">
        <!-- Mobile Menu -->
        <div class="lg:hidden">
          <UiSheet>
            <UiSheetTrigger :as-child="true">
              <UiButton variant="ghost" size="icon" class="mr-2 h-9 w-9">
                <Menu class="h-5 w-5" />
              </UiButton>
            </UiSheetTrigger>
            <UiSheetContent side="left" class="w-[300px] p-6">
              <UiSheetTitle class="sr-only">Navigation menu</UiSheetTitle>
              <UiSheetHeader class="flex justify-start text-left">
                <AppLogoIcon
                  class="size-6 fill-current text-black dark:text-white"
                />
              </UiSheetHeader>
              <div
                class="flex h-full flex-1 flex-col justify-between space-y-4 py-6"
              >
                <nav class="-mx-3 space-y-1">
                  <Link
                    v-for="item in mainNavItems"
                    :key="item.title"
                    :href="item.href"
                    class="flex items-center gap-x-3 rounded-lg px-3 py-2 text-sm font-medium hover:bg-accent"
                    :class="whenCurrentUrl(item.href, activeItemStyles)"
                  >
                    <component
                      v-if="item.icon"
                      :is="item.icon"
                      class="h-5 w-5"
                    />
                    {{ item.title }}
                  </Link>
                </nav>
                <div class="flex flex-col space-y-4">
                  <a
                    v-for="item in rightNavItems"
                    :key="item.title"
                    :href="toUrl(item.href)"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="flex items-center space-x-2 text-sm font-medium"
                  >
                    <component
                      v-if="item.icon"
                      :is="item.icon"
                      class="h-5 w-5"
                    />
                    <span>{{ item.title }}</span>
                  </a>
                </div>
              </div>
            </UiSheetContent>
          </UiSheet>
        </div>

        <Link :href="dashboard()" class="flex items-center gap-x-2">
          <AppLogo />
        </Link>

        <!-- Desktop Menu -->
        <div class="hidden h-full lg:flex lg:flex-1">
          <UiNavigationMenu class="ml-10 flex h-full items-stretch">
            <UiNavigationMenuList class="flex h-full items-stretch space-x-2">
              <UiNavigationMenuItem
                v-for="(item, index) in mainNavItems"
                :key="index"
                class="relative flex h-full items-center"
              >
                <Link
                  :class="[
                    navigationMenuTriggerStyle(),
                    whenCurrentUrl(item.href, activeItemStyles),
                    'h-9 cursor-pointer px-3',
                  ]"
                  :href="item.href"
                >
                  <component
                    v-if="item.icon"
                    :is="item.icon"
                    class="mr-2 h-4 w-4"
                  />
                  {{ item.title }}
                </Link>
                <div
                  v-if="isCurrentUrl(item.href)"
                  class="absolute bottom-0 left-0 h-0.5 w-full translate-y-px bg-black dark:bg-white"
                ></div>
              </UiNavigationMenuItem>
            </UiNavigationMenuList>
          </UiNavigationMenu>
        </div>

        <div class="ml-auto flex items-center space-x-2">
          <div class="relative flex items-center space-x-1">
            <UiButton
              variant="ghost"
              size="icon"
              class="group h-9 w-9 cursor-pointer"
            >
              <Search class="size-5 opacity-80 group-hover:opacity-100" />
            </UiButton>

            <div class="hidden space-x-1 lg:flex">
              <template v-for="item in rightNavItems" :key="item.title">
                <UiTooltipProvider :delay-duration="0">
                  <UiTooltip>
                    <UiTooltipTrigger>
                      <UiButton
                        variant="ghost"
                        size="icon"
                        as-child
                        class="group h-9 w-9 cursor-pointer"
                      >
                        <a
                          :href="toUrl(item.href)"
                          target="_blank"
                          rel="noopener noreferrer"
                        >
                          <span class="sr-only">{{ item.title }}</span>
                          <component
                            :is="item.icon"
                            class="size-5 opacity-80 group-hover:opacity-100"
                          />
                        </a>
                      </UiButton>
                    </UiTooltipTrigger>
                    <UiTooltipContent>
                      <p>{{ item.title }}</p>
                    </UiTooltipContent>
                  </UiTooltip>
                </UiTooltipProvider>
              </template>
            </div>
          </div>

          <UiDropdownMenu>
            <UiDropdownMenuTrigger :as-child="true">
              <UiButton
                variant="ghost"
                size="icon"
                class="relative size-10 w-auto rounded-full p-1 focus-within:ring-2 focus-within:ring-primary"
              >
                <UiAvatar class="size-8 overflow-hidden rounded-full">
                  <UiAvatarImage
                    v-if="auth.user.avatar"
                    :src="auth.user.avatar"
                    :alt="auth.user.name"
                  />
                  <UiAvatarFallback
                    class="rounded-lg bg-neutral-200 font-semibold text-black dark:bg-neutral-700 dark:text-white"
                  >
                    {{ getInitials(auth.user?.name) }}
                  </UiAvatarFallback>
                </UiAvatar>
              </UiButton>
            </UiDropdownMenuTrigger>
            <UiDropdownMenuContent align="end" class="w-56">
              <UserMenuContent :user="auth.user" />
            </UiDropdownMenuContent>
          </UiDropdownMenu>
        </div>
      </div>
    </div>

    <div
      v-if="props.breadcrumbs.length > 1"
      class="flex w-full border-b border-sidebar-border/70"
    >
      <div
        class="mx-auto flex h-12 w-full items-center justify-start px-4 text-neutral-500 md:max-w-7xl"
      >
        <Breadcrumbs :breadcrumbs="breadcrumbs" />
      </div>
    </div>
  </div>
</template>
