<script setup lang="ts">
import AuthBase from '@/layouts/AuthLayout.vue'
import { login } from '@/routes'
import { store } from '@/routes/register'
</script>

<template>
  <AuthBase
    title="Create an account"
    description="Enter your details below to create your account"
  >
    <Head title="Register" />

    <Form
      v-bind="store.form()"
      :reset-on-success="['password', 'password_confirmation']"
      v-slot="{ errors, processing }"
      class="flex flex-col gap-6"
    >
      <div class="grid gap-6">
        <div class="grid gap-2">
          <UiLabel for="name">Name</UiLabel>
          <UiInput
            id="name"
            type="text"
            required
            autofocus
            :tabindex="1"
            autocomplete="name"
            name="name"
            placeholder="Full name"
          />
          <InputError :message="errors.name" />
        </div>

        <div class="grid gap-2">
          <UiLabel for="email">Email address</UiLabel>
          <UiInput
            id="email"
            type="email"
            required
            :tabindex="2"
            autocomplete="email"
            name="email"
            placeholder="email@example.com"
          />
          <InputError :message="errors.email" />
        </div>

        <div class="grid gap-2">
          <UiLabel for="password">Password</UiLabel>
          <UiInput
            id="password"
            type="password"
            required
            :tabindex="3"
            autocomplete="new-password"
            name="password"
            placeholder="Password"
          />
          <InputError :message="errors.password" />
        </div>

        <div class="grid gap-2">
          <UiLabel for="password_confirmation">Confirm password</UiLabel>
          <UiInput
            id="password_confirmation"
            type="password"
            required
            :tabindex="4"
            autocomplete="new-password"
            name="password_confirmation"
            placeholder="Confirm password"
          />
          <InputError :message="errors.password_confirmation" />
        </div>

        <UiButton
          type="submit"
          class="mt-2 w-full"
          tabindex="5"
          :disabled="processing"
          data-test="register-user-button"
        >
          <UiSpinner v-if="processing" />
          Create account
        </UiButton>
      </div>

      <div class="text-muted-foreground text-center text-sm">
        Already have an account?
        <TextLink
          :href="login()"
          class="underline underline-offset-4"
          :tabindex="6"
        >
          Log in
        </TextLink>
      </div>
    </Form>
  </AuthBase>
</template>
