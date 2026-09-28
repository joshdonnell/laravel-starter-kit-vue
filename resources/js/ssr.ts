import { createInertiaApp } from '@inertiajs/vue3'
import createServer from '@inertiajs/vue3/server'
import { renderToString } from 'vue/server-renderer'
import { pageTitle, resolvePage, vFocus } from '@/lib/inertiaApp'

createServer(
  (page) =>
    createInertiaApp({
      page,
      render: renderToString,
      title: pageTitle,
      resolve: resolvePage,
      setup: ({ App, props, plugin }) =>
        createSSRApp({ render: () => h(App, props) })
          .use(plugin)
          .directive('focus', vFocus),
    }),
  { cluster: true },
)
