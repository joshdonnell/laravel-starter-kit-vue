<script setup lang="ts">
import AuthBase from '@/layouts/AuthLayout.vue'
import { register } from '@/wayfinder/routes'
import { store } from '@/wayfinder/routes/login'
import { request } from '@/wayfinder/routes/password'

defineProps<{
  status?: string
  canResetPassword: boolean
  canRegister: boolean
}>()
</script>

<template>
  <AuthBase
    title="Log in to your account"
    description="Enter your email and password below to log in"
  >
    <Head title="Log in" />

    <div
      v-if="status"
      class="mb-4 text-center text-sm font-medium text-green-600"
    >
      {{ status }}
    </div>

    <Form
      v-slot="{ errors, processing }"
      v-bind="store.form()"
      :reset-on-success="['password']"
      class="flex flex-col gap-6"
    >
      <div class="grid gap-6">
        <UFormField
          label="Email address"
          name="email"
          :error="errors.email"
        >
          <UInput
            id="email"
            type="email"
            name="email"
            required
            autofocus
            :tabindex="1"
            autocomplete="email"
            placeholder="email@example.com"
            class="w-full"
          />
        </UFormField>

        <UFormField
          name="password"
          :error="errors.password"
        >
          <slot name="label">
            <div class="mb-1 flex items-center justify-between">
              <label
                for="password"
                data-slot="label"
                class="text-default block font-medium"
              >
                Password</label
              >

              <UButton
                v-if="canResetPassword"
                :href="request().url"
                class="p-0 text-sm underline"
                :tabindex="5"
                variant="link"
              >
                Forgot password?
              </UButton>
            </div>
          </slot>

          <UInput
            id="password"
            type="password"
            name="password"
            required
            :tabindex="2"
            autocomplete="current-password"
            placeholder="Password"
            class="w-full"
          />
        </UFormField>

        <UCheckbox
          id="remember"
          name="remember"
          :tabindex="3"
          label="Remember me"
        />

        <UButton
          type="submit"
          varient="solid"
          class="mt-4 flex w-full justify-center"
          :tabindex="4"
          :loading="processing"
        >
          Log in
        </UButton>
      </div>

      <div
        v-if="canRegister"
        class="text-muted-foreground flex justify-center gap-x-1 text-center text-sm"
      >
        Don't have an account?
        <UButton
          :href="register().url"
          :tabindex="5"
          variant="link"
          class="p-0 underline"
        >
          Sign up
        </UButton>
      </div>
    </Form>
  </AuthBase>
</template>
