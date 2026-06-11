<script setup lang="ts">
import { usePasskeyRegister } from '@laravel/passkeys/vue'

const emit = defineEmits<{
  success: []
}>()

const getDefaultPasskeyName = (): string => {
  const ua = navigator.userAgent

  const browser = ['Chrome', 'Firefox', 'Safari', 'Edge', 'Opera'].find(
    (browser) => new RegExp(browser).test(ua),
  )

  const os = ['iPhone', 'iPad', 'Android', 'Mac', 'Windows'].find((os) =>
    new RegExp(os).test(ua),
  )

  return [browser, os].filter(Boolean).join(' on ') || ''
}

const name = ref<string>(getDefaultPasskeyName())
const showForm = ref<boolean>(false)

const { register, isLoading, error, isSupported } = usePasskeyRegister({
  onSuccess: () => {
    name.value = ''
    showForm.value = false
    emit('success')
  },
})

const handleSubmit = async (event: Event): Promise<void> => {
  event.preventDefault()

  if (!name.value.trim()) {
    return
  }

  await register(name.value)
}

const handleCancel = (): void => {
  showForm.value = false
  name.value = ''
}
</script>

<template>
  <div v-if="!isSupported" class="text-sm text-muted-foreground">
    Passkeys are not supported in this browser.
  </div>

  <UiButton v-else-if="!showForm" variant="outline" @click="showForm = true">
    Add passkey
  </UiButton>

  <form
    v-else
    @submit="handleSubmit"
    class="space-y-4 rounded-lg border border-border bg-muted/50 p-4"
  >
    <div class="grid gap-2">
      <UiLabel for="passkey-name">Passkey name</UiLabel>
      <UiInput
        id="passkey-name"
        type="text"
        v-model="name"
        placeholder="e.g., MacBook Pro, iPhone"
        class="mt-1 block w-full border-foreground/20"
        autofocus
      />
      <p class="text-xs text-muted-foreground">
        A name helps you identify this passkey later.
      </p>
    </div>

    <InputError v-if="error" :message="error" />

    <div class="flex gap-2">
      <UiButton type="submit" :disabled="isLoading || !name.trim()">
        {{ isLoading ? 'Registering...' : 'Register passkey' }}
      </UiButton>
      <UiButton type="button" variant="ghost" @click="handleCancel">
        Cancel
      </UiButton>
    </div>
  </form>
</template>
