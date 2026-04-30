<script setup lang="ts">
import { ShieldCheck } from 'lucide-vue-next'
import { edit, update } from '@/routes/password'
import { disable, enable } from '@/routes/two-factor'
import type { BreadcrumbItem } from '@/types'

type Props = {
  canManageTwoFactor?: boolean
  requiresConfirmation?: boolean
  twoFactorEnabled?: boolean
}

withDefaults(defineProps<Props>(), {
  canManageTwoFactor: false,
  requiresConfirmation: false,
  twoFactorEnabled: false,
})

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Security settings',
    href: edit(),
  },
]

const { hasSetupData, clearTwoFactorAuthData } = useTwoFactorAuth()
const showSetupModal = ref<boolean>(false)

onUnmounted(() => clearTwoFactorAuthData())
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Security settings" />

    <h1 class="sr-only">Security settings</h1>

    <SettingsLayout>
      <div class="space-y-6">
        <Heading
          variant="small"
          title="Update password"
          description="Ensure your account is using a long, random password to stay secure"
        />

        <Form
          v-bind="update.form()"
          :options="{
            preserveScroll: true,
          }"
          reset-on-success
          :reset-on-error="[
            'password',
            'password_confirmation',
            'current_password',
          ]"
          class="space-y-6"
          v-slot="{ errors, processing }"
        >
          <div class="grid gap-2">
            <UiLabel for="current_password">Current password</UiLabel>
            <PasswordInput
              id="current_password"
              name="current_password"
              class="mt-1 block w-full"
              autocomplete="current-password"
              placeholder="Current password"
            />
            <InputError :message="errors.current_password" />
          </div>

          <div class="grid gap-2">
            <UiLabel for="password">New password</UiLabel>
            <PasswordInput
              id="password"
              name="password"
              class="mt-1 block w-full"
              autocomplete="new-password"
              placeholder="New password"
            />
            <InputError :message="errors.password" />
          </div>

          <div class="grid gap-2">
            <UiLabel for="password_confirmation">Confirm password</UiLabel>
            <PasswordInput
              id="password_confirmation"
              name="password_confirmation"
              class="mt-1 block w-full"
              autocomplete="new-password"
              placeholder="Confirm password"
            />
            <InputError :message="errors.password_confirmation" />
          </div>

          <div class="flex items-center gap-4">
            <UiButton :disabled="processing" data-test="update-password-button">
              Save password
            </UiButton>
          </div>
        </Form>
      </div>

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
            When you enable two-factor authentication, you will be prompted for
            a secure pin during login. This pin can be retrieved from a
            TOTP-supported application on your phone.
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
              <UiButton type="submit" :disabled="processing">
                Enable 2FA
              </UiButton>
            </Form>
          </div>
        </div>

        <div v-else class="flex flex-col items-start justify-start space-y-4">
          <p class="text-sm text-muted-foreground">
            You will be prompted for a secure, random pin during login, which
            you can retrieve from the TOTP-supported application on your phone.
          </p>

          <div class="relative inline">
            <Form v-bind="disable.form()" #default="{ processing }">
              <UiButton
                variant="destructive"
                type="submit"
                :disabled="processing"
              >
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
    </SettingsLayout>
  </AppLayout>
</template>
