<script setup lang="ts">
import type { UrlMethodPair } from '@inertiajs/core'
import { usePasskeyVerify } from '@laravel/passkeys/vue'
import { KeyRound } from '@lucide/vue'

type Props = {
  routes?: {
    options: UrlMethodPair
    submit: UrlMethodPair
  }
  label?: string
  loadingLabel?: string
  separator?: string
}

const props = defineProps<Props>()

const { verify, isLoading, error, isSupported } = usePasskeyVerify({
  ...(props.routes
    ? {
        routes: {
          options: props.routes.options.url,
          submit: props.routes.submit.url,
        },
      }
    : {}),
  onSuccess: (response) => {
    router.visit(response.redirect ?? '/')
  },
})
</script>

<template>
  <div v-if="isSupported">
    <div class="grid gap-2">
      <UiButton
        type="button"
        variant="outline"
        class="w-full"
        @click="verify"
        :disabled="isLoading"
      >
        <UiSpinner v-if="isLoading" />
        <KeyRound v-else class="h-4 w-4" />
        {{
          isLoading
            ? (props.loadingLabel ?? 'Authenticating...')
            : (props.label ?? 'Sign in with a passkey')
        }}
      </UiButton>

      <div v-if="error" class="text-center">
        <InputError :message="error" />
      </div>
    </div>

    <div class="relative my-6">
      <div class="absolute inset-0 flex items-center">
        <UiSeparator class="w-full" />
      </div>
      <div class="relative flex justify-center text-xs uppercase">
        <span class="bg-background px-2 text-muted-foreground">
          {{ props.separator ?? 'Or continue with email' }}
        </span>
      </div>
    </div>
  </div>
</template>
