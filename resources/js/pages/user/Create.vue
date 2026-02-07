<script setup lang="ts">
import AuthBase from '@/layouts/AuthLayout.vue'
import { login } from '@/routes'
import { store } from '@/routes/register'
import { Form, Head } from '@inertiajs/vue3'
</script>

<template>
  <AuthBase
    title="Create an account"
    description="Enter your details below to create your account"
  >
    <Head title="Register" />

    <Form
      v-slot="{ errors, processing }"
      v-bind="store.form()"
      :reset-on-success="['password', 'password_confirmation']"
      class="flex flex-col gap-6"
    >
      <div class="grid gap-6">
        <UFormField
          label="Name"
          name="name"
          :error="errors.name"
        >
          <UInput
            id="name"
            type="text"
            required
            autofocus
            :tabindex="1"
            autocomplete="name"
            name="name"
            placeholder="Full name"
            class="w-full"
          />
        </UFormField>

        <UFormField
          label="Email"
          name="email"
          :error="errors.email"
        >
          <UInput
            id="email"
            type="email"
            required
            :tabindex="2"
            autocomplete="email"
            name="email"
            placeholder="email@example.com"
            class="w-full"
          />
        </UFormField>

        <UFormField
          label="Password"
          name="password"
          :error="errors.password"
        >
          <UInput
            id="password"
            type="password"
            required
            :tabindex="3"
            autocomplete="new-password"
            name="password"
            placeholder="Password"
            class="w-full"
          />
        </UFormField>

        <UFormField
          label="Confirm password"
          name="password_confirmation"
          :error="errors.password_confirmation"
        >
          <UInput
            id="password_confirmation"
            type="password"
            required
            :tabindex="4"
            autocomplete="new-password"
            name="password_confirmation"
            placeholder="Confirm password"
            class="w-full"
          />
        </UFormField>

        <UButton
          type="submit"
          class="mt-2 flex w-full justify-center"
          tabindex="5"
          :loading="processing"
        >
          Create account
        </UButton>
      </div>

      <div class="text-muted-foreground space-x-1 text-center text-sm">
        <span>Already have an account?</span>
        <UButton
          :href="login().url"
          class="p-0 underline"
          :tabindex="6"
          variant="link"
        >
          Log in
        </UButton>
      </div>
    </Form>
  </AuthBase>
</template>
