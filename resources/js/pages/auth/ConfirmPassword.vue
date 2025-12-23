<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
import { store } from '@/routes/password/confirm'
</script>

<template>
  <AuthLayout
    title="Confirm your password"
    description="This is a secure area of the application. Please confirm your password before continuing."
  >
    <Head title="Confirm password" />

    <Form
      v-bind="store.form()"
      reset-on-success
      v-slot="{ errors, processing }"
    >
      <div class="space-y-6">
        <div class="grid gap-2">
          <UiLabel htmlFor="password">Password</UiLabel>
          <UiInput
            id="password"
            type="password"
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
            Confirm Password
          </UiButton>
        </div>
      </div>
    </Form>
  </AuthLayout>
</template>
