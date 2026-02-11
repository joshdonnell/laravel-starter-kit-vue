import path from 'path'
import { wayfinder } from '@laravel/vite-plugin-wayfinder'
import ui from '@nuxt/ui/vite'
import tailwindcss from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import { defineConfig } from 'vite'
import { watch } from 'vite-plugin-watch'

const inertiaComponents: string[] = ['Link', 'Form', 'Head', 'Page', 'Deferred']

export default defineConfig({
  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
    },
  },
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
    ui({
      router: 'inertia',
      autoImport: {
        imports: ['vue', { '@inertiajs/vue3': ['useForm', 'usePage', 'useRemember', 'usePrefetch', 'router'] }],
        dirs: ['resources/js/composables'],
      },
      components: {
        dts: true,
        dirs: ['resources/js/components'],
        directoryAsNamespace: true,
        collapseSamePrefixes: true,
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
      },
    }),
    watch({
      pattern: 'app/{Data,Enums}/**/*.php',
      command: 'composer run transform-types',
    }),
  ],
})
