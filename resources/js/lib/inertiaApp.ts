import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import type { DefineComponent, Directive } from 'vue'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

export function pageTitle(title: string): string {
  return title ? `${title} - ${appName}` : appName
}

export function resolvePage(name: string): Promise<DefineComponent> {
  return resolvePageComponent(
    `../pages/${name}.vue`,
    import.meta.glob<DefineComponent>('../pages/**/*.vue'),
  )
}

export const vFocus: Directive<HTMLElement, boolean | undefined> = {
  mounted: (el, binding) => {
    if (binding.value !== false) {
      el.focus()
    }
  },
}
