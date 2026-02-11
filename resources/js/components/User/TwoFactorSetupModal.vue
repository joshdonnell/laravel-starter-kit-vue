<script setup lang="ts">
import { useClipboard, useColorMode } from '@vueuse/core'
import { confirm } from '@/routes/two-factor'
import type { TwoFactorConfigContent } from '@/types'

type Props = {
  requiresConfirmation: boolean
  twoFactorEnabled: boolean
}

const props = defineProps<Props>()
const isOpen = defineModel<boolean>('isOpen')

const colorMode = useColorMode()
const { copy, copied } = useClipboard()
const { qrCodeSvg, manualSetupKey, clearSetupData, fetchSetupData, errors } = useTwoFactorAuth()

const showVerificationStep = ref(false)
const code = ref<number[]>([])
const codeAsNumber = computed(() => code.value.join(''))

const modalConfig = computed<TwoFactorConfigContent>(() => {
  if (props.twoFactorEnabled) {
    return {
      title: 'Two-Factor Authentication Enabled',
      description: 'Two-factor authentication is now enabled. Scan the QR code or enter the setup key in your authenticator app.',
      buttonText: 'Close',
    }
  }

  if (showVerificationStep.value) {
    return {
      title: 'Verify Authentication Code',
      description: 'Enter the 6-digit code from your authenticator app',
      buttonText: 'Continue',
    }
  }

  return {
    title: 'Enable Two-Factor Authentication',
    description: 'To finish enabling two-factor authentication, scan the QR code or enter the setup key in your authenticator app',
    buttonText: 'Continue',
  }
})

const handleModalNextStep = () => {
  if (props.requiresConfirmation) {
    showVerificationStep.value = true
    return
  }

  clearSetupData()
  isOpen.value = false
}

const resetModalState = () => {
  if (props.twoFactorEnabled) {
    clearSetupData()
  }

  showVerificationStep.value = false
  code.value = []
}

watch(isOpen, async (value) => {
  if (!value) {
    resetModalState()
    return
  }

  if (!qrCodeSvg.value) {
    await fetchSetupData()
  }
})
</script>

<template>
  <UModal
    v-model:open="isOpen"
    :title="modalConfig.title"
    :description="modalConfig.description"
    :ui="{ header: 'flex flex-col items-center text-center', title: 'text-lg', description: 'text-center' }"
  >
    <template #body>
      <div class="flex flex-col items-center space-y-6 p-4">
        <template v-if="!showVerificationStep">
          <UAlert
            v-if="errors?.length"
            color="red"
            variant="soft"
            :title="errors[0]"
            icon="i-heroicons-exclamation-triangle"
            class="w-full"
          />
          <template v-else>
            <div class="flex w-full justify-center">
              <div class="relative aspect-square w-64 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                <div
                  v-if="!qrCodeSvg"
                  class="absolute inset-0 flex items-center justify-center bg-white dark:bg-gray-900"
                >
                  <UIcon
                    name="i-heroicons-arrow-path-20-solid"
                    class="size-6 animate-spin"
                  />
                </div>
                <div
                  v-else
                  class="border border-gray-200 p-5 dark:border-gray-700"
                >
                  <div
                    class="flex aspect-square size-full items-center justify-center"
                    :style="{
                      filter: colorMode === 'dark' ? 'invert(1) brightness(1.5)' : undefined,
                    }"
                    v-html="qrCodeSvg"
                  />
                </div>
              </div>
            </div>

            <UButton
              type="button"
              block
              @click="handleModalNextStep"
            >
              {{ modalConfig.buttonText }}
            </UButton>

            <USeparator label="or, enter the code manually" />

            <div
              v-if="!manualSetupKey"
              class="flex h-11 w-full items-center justify-center bg-gray-50 dark:bg-gray-800"
            >
              <UIcon
                name="i-heroicons-arrow-path-20-solid"
                class="animate-spin"
              />
            </div>
            <UInput
              v-else
              :model-value="manualSetupKey"
              readonly
              :ui="{ trailing: 'pr-0.5' }"
              class="w-full font-mono"
            >
              <template #trailing>
                <UTooltip
                  :text="copied ? 'Copied!' : 'Copy to clipboard'"
                  :content="{ side: 'right' }"
                >
                  <UButton
                    :color="copied ? 'success' : 'neutral'"
                    variant="link"
                    size="sm"
                    :icon="copied ? 'i-lucide-copy-check' : 'i-lucide-copy'"
                    aria-label="Copy to clipboard"
                    @click="copy(manualSetupKey || '')"
                  />
                </UTooltip>
              </template>
            </UInput>
          </template>
        </template>

        <template v-else>
          <div class="flex w-full flex-col items-center">
            <Form
              v-slot="{ errors: codeErrors, processing }"
              v-bind="confirm.form()"
              reset-on-error
              class="w-full space-y-6"
              @finish="code = []"
              @success="isOpen = false"
            >
              <input
                type="hidden"
                name="code"
                :value="codeAsNumber"
              />

              <div class="flex flex-col items-center">
                <UFormField
                  :error="codeErrors.code"
                  class="flex w-full justify-center"
                >
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
              </div>

              <div class="flex w-full gap-3">
                <UButton
                  type="button"
                  variant="soft"
                  block
                  :disabled="processing"
                  @click="showVerificationStep = false"
                >
                  Back
                </UButton>
                <UButton
                  type="submit"
                  block
                  :disabled="processing || code.length < 6"
                  :loading="processing"
                >
                  Confirm
                </UButton>
              </div>
            </Form>
          </div>
        </template>
      </div>
    </template>
  </UModal>
</template>
