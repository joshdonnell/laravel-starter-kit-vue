<script setup lang="ts">
import { ShieldCheck } from '@lucide/vue'
import { disable, enable } from '@/routes/two-factor'

export type Props = {
  canManageTwoFactor?: boolean
  requiresConfirmation?: boolean
  twoFactorEnabled?: boolean
}

withDefaults(defineProps<Props>(), {
  canManageTwoFactor: false,
  requiresConfirmation: false,
  twoFactorEnabled: false,
})

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth()
const showSetupModal = ref<boolean>(false)

onUnmounted(() => clearTwoFactorAuthData())
</script>

<template>
  <div v-if="canManageTwoFactor" class="space-y-6">
    <Heading
      variant="small"
      title="Two-factor authentication"
      description="Manage your two-factor authentication settings"
    />

    <div
      v-if="!twoFactorEnabled"
      class="flex flex-col items-start justify-start space-y-4"
    >
      <p class="text-sm text-muted-foreground">
        When you enable two-factor authentication, you will be prompted for a
        secure pin during login. This pin can be retrieved from a TOTP-supported
        application on your phone.
      </p>

      <div>
        <UiButton v-if="hasSetupData" @click="showSetupModal = true">
          <ShieldCheck />Continue setup
        </UiButton>
        <Form
          v-else
          v-bind="enable.form()"
          @success="showSetupModal = true"
          #default="{ processing }"
        >
          <UiButton type="submit" :disabled="processing"> Enable 2FA </UiButton>
        </Form>
      </div>
    </div>

    <div v-else class="flex flex-col items-start justify-start space-y-4">
      <p class="text-sm text-muted-foreground">
        You will be prompted for a secure, random pin during login, which you
        can retrieve from the TOTP-supported application on your phone.
      </p>

      <div class="relative inline">
        <Form v-bind="disable.form()" #default="{ processing }">
          <UiButton variant="destructive" type="submit" :disabled="processing">
            Disable 2FA
          </UiButton>
        </Form>
      </div>

      <TwoFactorRecoveryCodes />
    </div>

    <TwoFactorSetupModal
      v-model:isOpen="showSetupModal"
      :requiresConfirmation="requiresConfirmation"
      :twoFactorEnabled="twoFactorEnabled"
    />
  </div>
</template>
