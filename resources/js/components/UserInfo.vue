<script setup lang="ts">
import type { User } from '@/types'

type Props = {
  user: User
  showEmail?: boolean
}

const props = withDefaults(defineProps<Props>(), {
  showEmail: false,
})

const { getInitials } = useInitials()

// Compute whether we should show the avatar image
const showAvatar = computed(() => props.user.avatar && props.user.avatar !== '')
</script>

<template>
  <UiAvatar class="h-8 w-8 overflow-hidden rounded-lg">
    <UiAvatarImage v-if="showAvatar" :src="user.avatar!" :alt="user.name" />
    <UiAvatarFallback class="rounded-lg text-black dark:text-white">
      {{ getInitials(user.name) }}
    </UiAvatarFallback>
  </UiAvatar>

  <div class="grid flex-1 text-left text-sm leading-tight">
    <span class="truncate font-medium">{{ user.name }}</span>
    <span v-if="showEmail" class="truncate text-xs text-muted-foreground">{{
      user.email
    }}</span>
  </div>
</template>
