<script setup lang="ts">
import { edit, update } from '@/routes/user-profile'
import { send } from '@/routes/verification'
import type { BreadcrumbItem } from '@/types'

type Props = {
  mustVerifyEmail: boolean
  status?: string
}

defineProps<Props>()

const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: 'Profile settings',
    href: edit(),
  },
]

const page = usePage()
const user = computed(() => page.props.auth.user)
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head title="Profile settings" />

    <h1 class="sr-only">Profile settings</h1>

    <SettingsLayout>
      <div class="flex flex-col space-y-6">
        <Heading
          variant="small"
          title="Profile information"
          description="Update your name and email address"
        />

        <Form
          v-bind="update.form()"
          class="space-y-6"
          v-slot="{ errors, processing }"
        >
          <div class="grid gap-2">
            <UiLabel for="name">Name</UiLabel>
            <UiInput
              id="name"
              class="mt-1 block w-full"
              name="name"
              :default-value="user.name"
              required
              autocomplete="name"
              placeholder="Full name"
            />
            <InputError class="mt-2" :message="errors.name" />
          </div>

          <div class="grid gap-2">
            <UiLabel for="email">Email address</UiLabel>
            <UiInput
              id="email"
              type="email"
              class="mt-1 block w-full"
              name="email"
              :default-value="user.email"
              required
              autocomplete="username"
              placeholder="Email address"
            />
            <InputError class="mt-2" :message="errors.email" />
          </div>

          <div v-if="mustVerifyEmail && !user.email_verified_at">
            <p class="-mt-4 text-sm text-muted-foreground">
              Your email address is unverified.
              <Link
                :href="send()"
                as="button"
                class="text-foreground underline decoration-neutral-300 underline-offset-4 transition-colors duration-300 ease-out hover:decoration-current! dark:decoration-neutral-500"
              >
                Click here to resend the verification email.
              </Link>
            </p>

            <div
              v-if="status === 'verification-link-sent'"
              class="mt-2 text-sm font-medium text-green-600"
            >
              A new verification link has been sent to your email address.
            </div>
          </div>

          <div class="flex items-center gap-4">
            <UiButton :disabled="processing" data-test="update-profile-button"
              >Save</UiButton
            >
          </div>
        </Form>
      </div>

      <DeleteUser />
    </SettingsLayout>
  </AppLayout>
</template>
