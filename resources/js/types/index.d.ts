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

export type BreadcrumbItemType = BreadcrumbItem
