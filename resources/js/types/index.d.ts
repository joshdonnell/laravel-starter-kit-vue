import { InertiaLinkProps } from '@inertiajs/vue3'
import type { LucideIcon } from 'lucide-vue-next'

export interface Auth {
  user: App.Data.UserData
}

export interface BreadcrumbItem {
  title: string
  href: string
}

export interface NavItem {
  title: string
  href: NonNullable<InertiaLinkProps['href']>
  icon?: LucideIcon
  isActive?: boolean
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  name: string
  quote: { message: string; author: string }
  auth: App.Data.UserData
  sidebarOpen: boolean
}

export type BreadcrumbItemType = BreadcrumbItem
