<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import SettingsLayout from '@/layouts/settings/Layout.vue'
import { disable, enable, show } from '@/routes/two-factor'
import { BreadcrumbItem } from '@/types'
import { ShieldBan, ShieldCheck } from 'lucide-vue-next'

interface Props {
  requiresConfirmation?: boolean
  twoFactorEnabled?: boolean
}

withDefaults(defineProps<Props>(), {
  requiresConfirmation: false,
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
    <SettingsLayout>
      <div class="space-y-6">
        <HeadingSmall
          title="Two-Factor Authentication"
          description="Manage your two-factor authentication settings"
        />

        <div
          v-if="!twoFactorEnabled"
          class="flex flex-col items-start justify-start space-y-4"
        >
          <UiBadge variant="destructive">Disabled</UiBadge>

          <p class="text-muted-foreground">
            When you enable two-factor authentication, you will be prompted for a secure pin during login. This pin can be retrieved from a
            TOTP-supported application on your phone.
          </p>

          <div>
            <UiButton
              v-if="hasSetupData"
              @click="showSetupModal = true"
            >
              <ShieldCheck />Continue Setup
            </UiButton>
            <Form
              v-else
              v-bind="enable.form()"
              @success="showSetupModal = true"
              #default="{ processing }"
            >
              <Button
                type="submit"
                :disabled="processing"
              >
                <ShieldCheck />Enable 2FA</Button
              ></Form
            >
          </div>
        </div>

        <div
          v-else
          class="flex flex-col items-start justify-start space-y-4"
        >
          <UiBadge variant="default">Enabled</UiBadge>

          <p class="text-muted-foreground">
            With two-factor authentication enabled, you will be prompted for a secure, random pin during login, which you can retrieve from the
            TOTP-supported application on your phone.
          </p>

          <TwoFactorRecoveryCodes />

          <div class="relative inline">
            <Form
              v-bind="disable.form()"
              #default="{ processing }"
            >
              <UiButton
                variant="destructive"
                type="submit"
                :disabled="processing"
              >
                <ShieldBan />
                Disable 2FA
              </UiButton>
            </Form>
          </div>
        </div>

        <TwoFactorSetupModal
          v-model:isOpen="showSetupModal"
          :requiresConfirmation="requiresConfirmation"
          :twoFactorEnabled="twoFactorEnabled"
        />
      </div>
    </SettingsLayout>
  </AppLayout>
</template>
