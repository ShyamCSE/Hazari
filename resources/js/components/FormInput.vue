<script setup lang="ts">
defineProps<{
  modelValue: string | number
  id: string
  type: string
  label: string
  placeholder?: string
  min?: number
  max?: number
  error?: string
  helper?: string
}>()

const emit = defineEmits(['update:modelValue'])

function updateValue(e: Event) {
  const target = e.target as HTMLInputElement
  emit('update:modelValue', target.value)
}
</script>

<template>
  <div>
    <label :for="id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">{{ label }}</label>
    <input
      :id="id"
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :min="min"
      :max="max"
      class="mt-1 w-full rounded-xl border border-gray-300 dark:border-zinc-700 px-4 py-2 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
      @input="updateValue"
    />
    <p v-if="error" class="text-red-500 text-xs mt-1">{{ error }}</p>
    <p v-if="helper" class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ helper }}</p>
  </div>
</template>
