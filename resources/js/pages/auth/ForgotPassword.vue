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
        v-slot="{ errors, processing }"
        v-bind="email.form()"
      >
        <UFormField
          label="Email address"
          name="email"
          :error="errors.email"
        >
          <UInput
            id="email"
            type="email"
            name="email"
            autocomplete="off"
            autofocus
            required
            placeholder="email@example.com"
            class="w-full"
          />
        </UFormField>

        <div class="my-6 flex items-center justify-start">
          <UButton
            type="submit"
            class="flex w-full justify-center"
            :loading="processing"
          >
            Email password reset link
          </UButton>
        </div>
      </Form>

      <div class="text-muted-foreground space-x-1 text-center text-sm">
        <span>Or, return to</span>
        <UButton
          variant="link"
          class="p-0 underline"
          :href="login().url"
        >
          log in
        </UButton>
      </div>
    </div>
  </AuthLayout>
</template>
