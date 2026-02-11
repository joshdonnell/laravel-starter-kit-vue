<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
import { store } from '@/routes/two-factor/login'
import type { TwoFactorConfigContent } from '@/types'

const authConfigContent = computed<TwoFactorConfigContent>(() => {
  if (showRecoveryInput.value) {
    return {
      title: 'Recovery Code',
      description: 'Please confirm access to your account by entering one of your emergency recovery codes.',
      buttonText: 'login using an authentication code',
    }
  }

  return {
    title: 'Authentication Code',
    description: 'Enter the authentication code provided by your authenticator application.',
    buttonText: 'login using a recovery code',
  }
})

const showRecoveryInput = ref<boolean>(false)

const toggleRecoveryMode = (clearErrors: () => void): void => {
  showRecoveryInput.value = !showRecoveryInput.value
  clearErrors()
  code.value = []
}

const code = ref([])
const codeAsNumber = computed(() => code.value.join(''))
</script>

<template>
  <AuthLayout
    :title="authConfigContent.title"
    :description="authConfigContent.description"
  >
    <Head title="Two-Factor Authentication" />

    <div class="space-y-6">
      <template v-if="!showRecoveryInput">
        <Form
          v-slot="{ errors, processing, clearErrors }"
          v-bind="store.form()"
          class="space-y-4"
          reset-on-error
          @error="code = []"
        >
          <input
            type="hidden"
            name="code"
            :value="codeAsNumber"
          />
          <UFormField :error="errors.code">
            <UPinInput
              v-model="code"
              type="number"
              :disabled="processing"
              variant="subtle"
              placeholder="○"
              length="6"
              otp
            />
          </UFormField>
          <UButton
            type="submit"
            class="w-full"
            :loading="processing"
          >
            Continue
          </UButton>

          <div class="text-muted-foreground text-center text-sm">
            <span>or you can </span>

            <button
              type="button"
              class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
              @click="() => toggleRecoveryMode(clearErrors)"
            >
              {{ authConfigContent.buttonText }}
            </button>
          </div>
        </Form>
      </template>

      <template v-else>
        <Form
          v-slot="{ errors, processing, clearErrors }"
          v-bind="store.form()"
          class="space-y-4"
          reset-on-error
        >
          <UFormField :error="errors.recovery_code">
            <UInput
              name="recovery_code"
              type="text"
              placeholder="Enter recovery code"
              :autofocus="showRecoveryInput"
              required
            />
          </UFormField>

          <UButton
            type="submit"
            class="w-full"
            :loading="processing"
          >
            Continue
          </UButton>

          <div class="text-muted-foreground text-center text-sm">
            <span>or you can </span>
            <button
              type="button"
              class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
              @click="() => toggleRecoveryMode(clearErrors)"
            >
              {{ authConfigContent.buttonText }}
            </button>
          </div>
        </Form>
      </template>
    </div>
  </AuthLayout>
</template>
