<script setup lang="ts">
defineProps<{
  title?: string
  description?: string
}>()
</script>

<template>
  <AuthSimpleLayout :title="title" :description="description">
    <slot />
  </AuthSimpleLayout>
</template>
