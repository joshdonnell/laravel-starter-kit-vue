<script setup lang="ts">
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
      v-bind="store.form()"
      :transform="(data) => ({ ...data, token, email })"
      :reset-on-success="['password', 'password_confirmation']"
      v-slot="{ errors, processing, validate }"
    >
      <div class="grid gap-6">
        <div class="grid gap-2">
          <UiLabel for="email">Email</UiLabel>
          <UiInput
            id="email"
            type="email"
            name="email"
            autocomplete="email"
            v-model="inputEmail"
            class="mt-1 block w-full"
            readonly
          />
          <InputError :message="errors.email" class="mt-2" />
        </div>

        <div class="grid gap-2">
          <UiLabel for="password">Password</UiLabel>
          <PasswordInput
            id="password"
            name="password"
            autocomplete="new-password"
            class="mt-1 block w-full"
            autofocus
            placeholder="Password"
            @change="validate('password')"
          />
          <InputError :message="errors.password" />
        </div>

        <div class="grid gap-2">
          <UiLabel for="password_confirmation"> Confirm password </UiLabel>
          <PasswordInput
            id="password_confirmation"
            name="password_confirmation"
            autocomplete="new-password"
            class="mt-1 block w-full"
            placeholder="Confirm password"
            @change="validate('password_confirmation')"
          />
          <InputError :message="errors.password_confirmation" />
        </div>

        <UiButton
          type="submit"
          class="mt-4 w-full"
          :disabled="processing"
          data-test="reset-password-button"
        >
          <UiSpinner v-if="processing" />
          Reset password
        </UiButton>
      </div>
    </Form>
  </AuthLayout>
</template>
