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
      v-slot="{ errors, processing }"
      v-bind="store.form()"
      reset-on-success
    >
      <div class="space-y-6">
        <UFormField
          name="password"
          label="Password"
          :error="errors.password"
        >
          <UInput
            id="password"
            type="password"
            name="password"
            class="mt-1 block w-full"
            required
            autocomplete="current-password"
            autofocus
          />
        </UFormField>

        <div class="flex items-center">
          <UButton
            type="submit"
            class="flex w-full justify-center"
            :loading="processing"
          >
            Confirm Password
          </UButton>
        </div>
      </div>
    </Form>
  </AuthLayout>
</template>
