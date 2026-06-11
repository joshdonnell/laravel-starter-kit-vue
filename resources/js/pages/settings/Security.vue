<script setup lang="ts">
import type { Props as ManagePasskeysProps } from '@/components/ManagePasskeys.vue'
import type { Props as ManageTwoFactorProps } from '@/components/ManageTwoFactor.vue'
import { edit, update } from '@/routes/password'
import type { BreadcrumbItem } from '@/types'

type Props = ManagePasskeysProps & ManageTwoFactorProps

defineProps<Props>()

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Security settings',
    href: edit(),
  },
]
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
              Save
            </UiButton>
          </div>
        </Form>
      </div>

      <ManageTwoFactor
        :canManageTwoFactor="canManageTwoFactor"
        :requiresConfirmation="requiresConfirmation"
        :twoFactorEnabled="twoFactorEnabled"
      />

      <ManagePasskeys
        :canManagePasskeys="canManagePasskeys"
        :passkeys="passkeys"
      />
    </SettingsLayout>
  </AppLayout>
</template>
