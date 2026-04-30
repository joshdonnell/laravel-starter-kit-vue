<script setup lang="ts">
import { home } from '@/routes'

defineProps<{
  title?: string
  description?: string
}>()
</script>

<template>
  <div
    class="flex min-h-svh flex-col items-center justify-center gap-6 bg-muted p-6 md:p-10"
  >
    <div class="flex w-full max-w-md flex-col gap-6">
      <Link
        :href="home()"
        class="flex items-center gap-2 self-center font-medium"
      >
        <div class="flex h-9 w-9 items-center justify-center">
          <AppLogoIcon class="size-9 fill-current text-black dark:text-white" />
        </div>
      </Link>

      <div class="flex flex-col gap-6">
        <UiCard class="rounded-xl">
          <UiCardHeader class="px-10 pt-8 pb-0 text-center">
            <UiCardTitle class="text-xl">{{ title }}</UiCardTitle>
            <UiCardDescription>
              {{ description }}
            </UiCardDescription>
          </UiCardHeader>
          <UiCardContent class="px-10 py-8">
            <slot />
          </UiCardContent>
        </UiCard>
      </div>
    </div>
  </div>
</template>
