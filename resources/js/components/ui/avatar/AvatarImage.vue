<script setup lang="ts">
import type { AvatarImageProps } from "reka-ui"
const props = defineProps<AvatarImageProps>()
</script>

<template>
  <RekaAvatarImage
    data-slot="avatar-image"
    v-bind="props"
    class="aspect-square size-full"
  >
    <slot />
  </RekaAvatarImage>
</template>
