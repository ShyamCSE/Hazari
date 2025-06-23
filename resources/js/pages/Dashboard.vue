<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem } from '@/types'
import { Head, usePage, router } from '@inertiajs/vue3'

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/dashboard' },
]

const page = usePage()
const recentAttendances = page.props.recentAttendances ?? []
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <!-- Heading -->
      <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Welcome to Admin Dashboard</h2>
      </div>

      <!-- Attendance Action Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
          class="bg-indigo-600 text-white p-6 rounded-xl shadow hover:scale-[1.02] transition cursor-pointer"
          @click="router.visit('/gps')"
        >
          <h3 class="text-lg font-semibold mb-2">GPS Attendance</h3>
          <p class="text-sm">Manage and view GPS-based attendance.</p>
        </div>

        <div
          class="bg-green-600 text-white p-6 rounded-xl shadow hover:scale-[1.02] transition cursor-pointer"
          @click="router.visit('/wifi')"
        >
          <h3 class="text-lg font-semibold mb-2">Wi-Fi Attendance</h3>
          <p class="text-sm">Set and track attendance using Wi-Fi networks.</p>
        </div>

        <div
          class="bg-yellow-500 text-white p-6 rounded-xl shadow hover:scale-[1.02] transition cursor-pointer"
          @click="router.visit('/manual-attendance')"
        >
          <h3 class="text-lg font-semibold mb-2">Manual Attendance</h3>
          <p class="text-sm">Approve or manage manual attendance requests.</p>
        </div>
      </div>

      <!-- Recent Attendance -->
      <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
          <h3 class="text-lg font-semibold">Recent Attendance</h3>
        </div>

        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
              <th class="px-6 py-3">User</th>
              <th class="px-6 py-3">Date</th>
              <th class="px-6 py-3">Check In</th>
              <th class="px-6 py-3">Check Out</th>
              <th class="px-6 py-3">Method</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="item in recentAttendances"
              :key="item.id"
              class="border-t dark:border-gray-700"
            >
              <td class="px-6 py-2">{{ item.user?.name ?? '-' }}</td>
              <td class="px-6 py-2">{{ item.date }}</td>
              <td class="px-6 py-2">{{ item.check_in ?? '-' }}</td>
              <td class="px-6 py-2">{{ item.check_out ?? '-' }}</td>
              <td class="px-6 py-2 capitalize">{{ item.method }}</td>
            </tr>
            <tr v-if="recentAttendances.length === 0">
              <td colspan="5" class="px-6 py-4 text-center text-gray-500">No attendance data available.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>
