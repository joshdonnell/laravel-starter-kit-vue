<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
import { store } from '@/routes/password'

const props = defineProps<{
  token: string
  email: string
}>()

const inputEmail = ref(props.email)
</script>

<template>
  <AuthLayout
    title="Reset password"
    description="Please enter your new password below"
  >
    <Head title="Reset password" />

    <Form
      v-slot="{ errors, processing }"
      v-bind="store.form()"
      :transform="(data) => ({ ...data, token, email })"
      :reset-on-success="['password', 'password_confirmation']"
    >
      <div class="grid gap-6">
        <UFormField
          name="email"
          label="Email"
          :error="errors.email"
        >
          <UInput
            id="email"
            v-model="inputEmail"
            type="email"
            name="email"
            class="mt-1 block w-full"
            readonly
            disabled
          />
        </UFormField>

        <UFormField
          name="password"
          label="Password"
          :error="errors.password"
        >
          <UInput
            id="password"
            type="password"
            name="password"
            autocomplete="new-password"
            class="mt-1 block w-full"
            autofocus
            placeholder="Password"
          />
        </UFormField>

        <UFormField
          name="password_confirmation"
          label="Confirm Password"
          :error="errors.password_confirmation"
        >
          <UInput
            id="password_confirmation"
            type="password"
            name="password_confirmation"
            autocomplete="new-password"
            class="mt-1 block w-full"
            placeholder="Confirm password"
          />
        </UFormField>

        <UButton
          type="submit"
          class="mt-4 flex w-full justify-center"
          :loading="processing"
        >
          Reset password
        </UButton>
      </div>
    </Form>
  </AuthLayout>
</template>
