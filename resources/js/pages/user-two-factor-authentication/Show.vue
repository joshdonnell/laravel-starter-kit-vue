<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import SettingsLayout from '@/layouts/settings/Layout.vue'
import { disable, enable, show } from '@/routes/two-factor'
import type { BreadcrumbItem } from '@/types'

type Props = {
  requiresConfirmation?: boolean
  twoFactorEnabled?: boolean
}

withDefaults(defineProps<Props>(), {
  requiresConfirmation: true,
  twoFactorEnabled: false,
})

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Two-Factor Authentication',
    href: show.url(),
  },
]

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth()
const showSetupModal = ref<boolean>(false)

onUnmounted(() => {
  clearTwoFactorAuthData()
})
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Two-Factor Authentication" />

    <h1 class="sr-only">Two-Factor Authentication Settings</h1>

    <SettingsLayout>
      <div class="space-y-6">
        <SharedHeading
          variant="small"
          title="Two-Factor Authentication"
          description="Manage your two-factor authentication settings"
        />

        <div
          v-if="!twoFactorEnabled"
          class="flex flex-col items-start justify-start space-y-4"
        >
          <UBadge color="error">Disabled</UBadge>

          <p class="text-muted-foreground">
            When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a
            TOTP-supported application on your phone.
          </p>

          <div>
            <UButton
              v-if="hasSetupData"
              @click="showSetupModal = true"
            >
              Continue Setup
            </UButton>
            <Form
              v-else
              v-slot="{ processing }"
              v-bind="enable.form()"
              @success="showSetupModal = true"
            >
              <UButton
                type="submit"
                :disabled="processing"
                icon="i-lucide-shield-check"
              >
                Enable 2FA
              </UButton>
            </Form>
          </div>
        </div>

        <div
          v-else
          class="flex flex-col items-start justify-start space-y-4"
        >
          <UBadge color="success">Enabled</UBadge>

          <p class="text-muted-foreground">
            With two-factor authentication enabled, you will be prompted for a secure, random pin during login, which you can retrieve from the
            TOTP-supported application on your phone.
          </p>

          <UserTwoFactorRecoveryCodes />

          <div class="relative inline">
            <Form
              v-slot="{ processing }"
              v-bind="disable.form()"
            >
              <UButton
                color="error"
                type="submit"
                :loading="processing"
                icon="i-lucide-shield-x"
              >
                Disable 2FA
              </UButton>
            </Form>
          </div>
        </div>

        <UserTwoFactorSetupModal
          v-model:is-open="showSetupModal"
          :requires-confirmation="requiresConfirmation"
          :two-factor-enabled="twoFactorEnabled"
        />
      </div>
    </SettingsLayout>
  </AppLayout>
</template>
