import { createInertiaApp } from '@inertiajs/vue3'
import { initializeFlashToast } from '@/lib/flashToast'
import { pageTitle, resolvePage, vFocus } from '@/lib/inertiaApp'

void createInertiaApp({
  title: pageTitle,
  resolve: resolvePage,
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .directive('focus', vFocus)
      .mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})

// This will set light / dark mode on page load...
initializeTheme()

// This will listen for flash toast data from the server...
initializeFlashToast()
