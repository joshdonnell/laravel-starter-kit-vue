<script setup lang="ts">
import AuthLayout from '@/layouts/AuthLayout.vue'
import { store } from '@/routes/two-factor/login'

interface AuthConfigContent {
  title: string
  description: string
  toggleText: string
}

const authConfigContent = computed<AuthConfigContent>(() => {
  if (showRecoveryInput.value) {
    return {
      title: 'Recovery Code',
      description: 'Please confirm access to your account by entering one of your emergency recovery codes.',
      toggleText: 'login using an authentication code',
    }
  }

  return {
    title: 'Authentication Code',
    description: 'Enter the authentication code provided by your authenticator application.',
    toggleText: 'login using a recovery code',
  }
})

const showRecoveryInput = ref<boolean>(false)

const toggleRecoveryMode = (clearErrors: () => void): void => {
  showRecoveryInput.value = !showRecoveryInput.value
  clearErrors()
  code.value = ''
}

const code = ref<string>('')
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
          v-bind="store.form()"
          class="space-y-4"
          reset-on-error
          @error="code = ''"
          #default="{ errors, processing, clearErrors }"
        >
          <input
            type="hidden"
            name="code"
            :value="code"
          />
          <div class="flex flex-col items-center justify-center space-y-3 text-center">
            <div class="flex w-full items-center justify-center">
              <UiInputOTP
                id="otp"
                v-model="code"
                :maxlength="6"
                :disabled="processing"
                autofocus
              >
                <UiInputOTPGroup>
                  <UiInputOTPSlot
                    v-for="index in 6"
                    :key="index"
                    :index="index - 1"
                  />
                </UiInputOTPGroup>
              </UiInputOTP>
            </div>
            <InputError :message="errors.code" />
          </div>
          <UiButton
            type="submit"
            class="w-full"
            :disabled="processing"
          >
            Continue
          </UiButton>
          <div class="text-muted-foreground text-center text-sm">
            <span>or you can </span>
            <button
              type="button"
              class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
              @click="() => toggleRecoveryMode(clearErrors)"
            >
              {{ authConfigContent.toggleText }}
            </button>
          </div>
        </Form>
      </template>

      <template v-else>
        <Form
          v-bind="store.form()"
          class="space-y-4"
          reset-on-error
          #default="{ errors, processing, clearErrors }"
        >
          <UiInput
            name="recovery_code"
            type="text"
            placeholder="Enter recovery code"
            :autofocus="showRecoveryInput"
            required
          />
          <InputError :message="errors.recovery_code" />
          <UiButton
            type="submit"
            class="w-full"
            :disabled="processing"
          >
            Continue
          </UiButton>

          <div class="text-muted-foreground text-center text-sm">
            <span>or you can </span>
            <button
              type="button"
              class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
              @click="() => toggleRecoveryMode(clearErrors)"
            >
              {{ authConfigContent.toggleText }}
            </button>
          </div>
        </Form>
      </template>
    </div>
  </AuthLayout>
</template>
