<script setup lang="ts">
import {
  index as confirmOptions,
  store as confirmStore,
} from '@/actions/Laravel/Passkeys/Http/Controllers/PasskeyConfirmationController'
import { store } from '@/routes/password/confirm'
</script>

<template>
  <AuthLayout
    title="Confirm password"
    description="This is a secure area of the application. Please confirm your password before continuing."
  >
    <Head title="Confirm password" />

    <PasskeyVerify
      :routes="{
        options: confirmOptions(),
        submit: confirmStore(),
      }"
      label="Confirm with passkey"
      loading-label="Confirming..."
      separator="Or confirm with password"
    />

    <Form
      v-bind="store.form()"
      reset-on-success
      v-slot="{ errors, processing }"
    >
      <div class="space-y-6">
        <div class="grid gap-2">
          <UiLabel htmlFor="password">Password</UiLabel>
          <PasswordInput
            id="password"
            name="password"
            class="mt-1 block w-full"
            required
            autocomplete="current-password"
            autofocus
          />

          <InputError :message="errors.password" />
        </div>

        <div class="flex items-center">
          <UiButton
            class="w-full"
            :disabled="processing"
            data-test="confirm-password-button"
          >
            <UiSpinner v-if="processing" />
            Confirm password
          </UiButton>
        </div>
      </div>
    </Form>
  </AuthLayout>
</template>
