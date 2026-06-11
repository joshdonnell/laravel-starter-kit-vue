<script setup lang="ts">
import { AlertCircle } from '@lucide/vue'
type Props = {
  errors: string[]
  title?: string
}

const props = withDefaults(defineProps<Props>(), {
  title: 'Something went wrong.',
})

const uniqueErrors = computed(() => Array.from(new Set(props.errors)))
</script>

<template>
  <UiAlert variant="destructive">
    <AlertCircle class="size-4" />
    <UiAlertTitle>{{ title }}</UiAlertTitle>
    <UiAlertDescription>
      <ul class="list-inside list-disc text-sm">
        <li v-for="(error, index) in uniqueErrors" :key="index">
          {{ error }}
        </li>
      </ul>
    </UiAlertDescription>
  </UiAlert>
</template>
