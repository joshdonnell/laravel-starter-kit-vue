<script setup lang="ts">
import AuthBase from '@/layouts/AuthLayout.vue'
import { register } from '@/routes'
import { store } from '@/routes/login'
import { request } from '@/routes/password'

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
      v-bind="store.form()"
      :reset-on-success="['password']"
      v-slot="{ errors, processing }"
      class="flex flex-col gap-6"
    >
      <div class="grid gap-6">
        <div class="grid gap-2">
          <UiLabel for="email">Email address</UiLabel>
          <UiInput
            id="email"
            type="email"
            name="email"
            required
            autofocus
            :tabindex="1"
            autocomplete="email"
            placeholder="email@example.com"
          />
          <InputError :message="errors.email" />
        </div>

        <div class="grid gap-2">
          <div class="flex items-center justify-between">
            <UiLabel for="password">Password</UiLabel>
            <TextLink
              v-if="canResetPassword"
              :href="request()"
              class="text-sm"
              :tabindex="5"
            >
              Forgot password?
            </TextLink>
          </div>
          <UiInput
            id="password"
            type="password"
            name="password"
            required
            :tabindex="2"
            autocomplete="current-password"
            placeholder="Password"
          />
          <InputError :message="errors.password" />
        </div>

        <div class="flex items-center justify-between">
          <UiLabel
            for="remember"
            class="flex items-center space-x-3"
          >
            <UiCheckbox
              id="remember"
              name="remember"
              :tabindex="3"
            />
            <span>Remember me</span>
          </UiLabel>
        </div>

        <UiButton
          type="submit"
          class="mt-4 w-full"
          :tabindex="4"
          :disabled="processing"
          data-test="login-button"
        >
          <UiSpinner v-if="processing" />
          Log in
        </UiButton>
      </div>

      <div
        class="text-muted-foreground text-center text-sm"
        v-if="canRegister"
      >
        Don't have an account?
        <TextLink
          :href="register()"
          :tabindex="5"
          >Sign up</TextLink
        >
      </div>
    </Form>
  </AuthBase>
</template>
