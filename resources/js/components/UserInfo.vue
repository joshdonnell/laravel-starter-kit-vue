<script setup lang="ts">
import type { User } from '@/types'

const props = withDefaults(
  defineProps<{
    user: User
    showEmail?: boolean
  }>(),
  {
    showEmail: false,
  },
)

const initials = computed(() => getInitials(props.user.name))
</script>

<template>
  <div class="flex flex-1 items-center gap-2">
    <UiAvatar class="h-8 w-8 overflow-hidden rounded-lg">
      <UiAvatarFallback class="rounded-lg text-black dark:text-white">
        {{ initials }}
      </UiAvatarFallback>
    </UiAvatar>

    <div class="grid flex-1 text-left text-sm leading-tight">
      <span class="truncate font-medium">{{ user.name }}</span>
      <span v-if="showEmail" class="truncate text-xs text-muted-foreground">{{
        user.email
      }}</span>
    </div>
  </div>
</template>
