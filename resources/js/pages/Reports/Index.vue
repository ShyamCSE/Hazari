<script setup lang="ts">
import { Head } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Reports', href: '/reports' }
]
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Reports" />

    <div class="p-6 space-y-6">
      <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Reports</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="border border-gray-200 dark:border-gray-700 rounded p-4 bg-white dark:bg-gray-900">
          <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">Attendance Summary</h3>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            View overall attendance logs for Wi-Fi, GPS, and Manual entries.
          </p>
          <a href="/reports/attendance" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
            View Attendance Report →
          </a>
        </div>

        <div class="border border-gray-200 dark:border-gray-700 rounded p-4 bg-white dark:bg-gray-900">
          <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">User Activity</h3>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            See login history, device logs, and status updates.
          </p>
          <a href="/device-logs" class="text-blue-600 hover:underline text-sm mt-2 inline-block">
            View Device Logs →
          </a>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
