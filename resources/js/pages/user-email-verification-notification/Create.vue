<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
import { logout } from '@/routes'
import { send } from '@/routes/verification'
import { Form, Head } from '@inertiajs/vue3'

defineProps<{
  status?: string
}>()
</script>

<template>
  <AuthLayout
    title="Verify email"
    description="Please verify your email address by clicking on the link we just emailed to you."
  >
    <Head title="Email verification" />

    <div
      v-if="status === 'verification-link-sent'"
      class="mb-4 text-center text-sm font-medium text-green-600"
    >
      A new verification link has been sent to the email address you provided during registration.
    </div>

    <Form
      v-slot="{ processing }"
      v-bind="send.form()"
      class="space-y-6 text-center"
    >
      <UButton :loading="processing"> Resend verification email </UButton>

      <UButton
        :href="logout().url"
        class="mx-auto block text-sm underline"
        variant="link"
      >
        Log out
      </UButton>
    </Form>
  </AuthLayout>
</template>
