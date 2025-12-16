import { wayfinder } from '@laravel/vite-plugin-wayfinder'
import tailwindcss from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { defineConfig } from 'vite'
import { watch } from 'vite-plugin-watch'

const inertiaComponents = ['Link', 'Form', 'Head', 'Page', 'Deferred']

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/js/app.ts'],
      ssr: 'resources/js/ssr.ts',
      refresh: true,
    }),
    tailwindcss(),
    wayfinder({
      formVariants: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    AutoImport({
      imports: ['vue', { '@inertiajs/vue3': ['useForm', 'usePage', 'useRemember', 'usePrefetch', 'router'] }],
      dirs: ['resources/js/composables'],
    }),
    Components({
      dts: true,
      dirs: ['resources/js/components'],
      directoryAsNamespace: true,
      types: [
        {
          names: inertiaComponents,
          from: '@inertiajs/vue3',
        },
      ],
      resolvers: [
        (component: string) => {
          if (inertiaComponents.includes(component)) {
            return {
              name: component,
              from: '@inertiajs/vue3',
            }
          }

          return undefined
        },
      ],
    }),
    watch({
      pattern: 'app/{Data,Enums}/**/*.php',
      command: 'composer run transform-types',
    }),
  ],
})
