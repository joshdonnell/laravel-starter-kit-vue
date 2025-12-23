<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
import { login } from '@/routes'
import { email } from '@/routes/password'

defineProps<{
  status?: string
}>()
</script>

<template>
  <AuthLayout
    title="Forgot password"
    description="Enter your email to receive a password reset link"
  >
    <Head title="Forgot password" />

    <div
      v-if="status"
      class="mb-4 text-center text-sm font-medium text-green-600"
    >
      {{ status }}
    </div>

    <div class="space-y-6">
      <Form
        v-bind="email.form()"
        v-slot="{ errors, processing }"
      >
        <div class="grid gap-2">
          <UiLabel for="email">Email address</UiLabel>
          <UiInput
            id="email"
            type="email"
            name="email"
            autocomplete="off"
            autofocus
            placeholder="email@example.com"
          />
          <InputError :message="errors.email" />
        </div>

        <div class="my-6 flex items-center justify-start">
          <UiButton
            class="w-full"
            :disabled="processing"
            data-test="email-password-reset-link-button"
          >
            <UiSpinner v-if="processing" />
            Email password reset link
          </UiButton>
        </div>
      </Form>

      <div class="text-muted-foreground space-x-1 text-center text-sm">
        <span>Or, return to</span>
        <TextLink :href="login()">log in</TextLink>
      </div>
    </div>
  </AuthLayout>
</template>
