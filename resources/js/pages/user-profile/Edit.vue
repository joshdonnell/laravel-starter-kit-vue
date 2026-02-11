<script setup lang="ts">
import ProfileController from '@/actions/App/Http/Controllers/UserProfileController'
import AppLayout from '@/layouts/AppLayout.vue'
import SettingsLayout from '@/layouts/settings/Layout.vue'
import { edit } from '@/routes/user-profile'
import { send } from '@/routes/verification'
import { type BreadcrumbItem } from '@/types'

type Props = {
  mustVerifyEmail: boolean
  status?: string
}

defineProps<Props>()

const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: 'Profile settings',
    href: edit().url,
  },
]

const page = usePage()
const user = page.props.auth.user
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head title="Profile settings" />

    <h1 class="sr-only">Profile Settings</h1>

    <SettingsLayout>
      <div class="flex flex-col space-y-6">
        <SharedHeading
          variant="small"
          title="Profile information"
          description="Update your name and email address"
        />

        <Form
          v-slot="{ errors, processing, recentlySuccessful }"
          v-bind="ProfileController.update().form"
          class="space-y-6"
        >
          <UFormField
            name="name"
            label="Name"
            :error="errors.name"
          >
            <UInput
              id="name"
              class="mt-1 block w-full"
              name="name"
              :default-value="user.name"
              required
              autocomplete="name"
              placeholder="Full name"
            />
          </UFormField>

          <UFormField
            name="email"
            label="Email address"
            :error="errors.email"
          >
            <UInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              name="email"
              :default-value="user.email"
              required
              autocomplete="username"
              placeholder="Email address"
            />
          </UFormField>

          <div v-if="mustVerifyEmail && !user.email_verified_at">
            <p class="text-muted-foreground -mt-4 text-sm">
              Your email address is unverified.
              <UButton
                :href="send()"
                variant="link"
                class="p-0 underline"
              >
                Click here to resend the verification email.
              </UButton>
            </p>

            <div
              v-if="status === 'verification-link-sent'"
              class="mt-2 text-sm font-medium text-green-600"
            >
              A new verification link has been sent to your email address.
            </div>
          </div>

          <div class="flex items-center gap-4">
            <UButton
              type="submit"
              :loading="processing"
            >
              Save
            </UButton>

            <Transition
              enter-active-class="transition ease-in-out"
              enter-from-class="opacity-0"
              leave-active-class="transition ease-in-out"
              leave-to-class="opacity-0"
            >
              <p
                v-show="recentlySuccessful"
                class="text-sm text-neutral-600"
              >
                Saved.
              </p>
            </Transition>
          </div>
        </Form>
      </div>

      <!--      <DeleteUser />-->
    </SettingsLayout>
  </AppLayout>
</template>
