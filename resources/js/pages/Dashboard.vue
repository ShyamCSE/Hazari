<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, usePage, router } from '@inertiajs/vue3'
import { type BreadcrumbItem } from '@/types'
import { CheckCircle, AlertCircle } from 'lucide-vue-next';

// Dummy setup states - replace with real props from backend
const gpsSetup = true;
const wifiSetup = false;
const manualSetup = true;
const page = usePage();
const stats = page.props.stats ?? {
  totalUsers: 0,
  presentToday: 0,
  activeUsers: 0,
};

const recentAttendances = page.props.recentAttendances ?? [];

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Dashboard', href: '/dashboard' },
]
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="p-6 space-y-6">
      <!-- 🔹 Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-900 border rounded-xl p-6 shadow">
          <h3 class="text-sm text-gray-500">Total Users</h3>
          <p class="text-2xl font-bold text-indigo-600">{{ stats.totalUsers }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 border rounded-xl p-6 shadow">
          <h3 class="text-sm text-gray-500">Present Today</h3>
          <p class="text-2xl font-bold text-green-600">{{ stats.presentToday }}</p>
        </div>
        <div class="bg-white dark:bg-gray-900 border rounded-xl p-6 shadow">
          <h3 class="text-sm text-gray-500">Active Users</h3>
          <p class="text-2xl font-bold text-yellow-600">{{ stats.activeUsers }}</p>
        </div>
      </div>

      <!-- 🔹 Attendance Quick Links -->
   <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- GPS Attendance -->
    <div
      class="p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 transition hover:shadow-xl cursor-pointer"
      @click="router.visit('/gps')"
    >
      <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-semibold text-indigo-700 dark:text-indigo-300">GPS Attendance</h3>
        <component
          :is="gpsSetup ? CheckCircle : AlertCircle"
          class="w-5 h-5"
          :class="gpsSetup ? 'text-green-500' : 'text-yellow-500'"
        />
      </div>
      <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
        Manage and view GPS-based attendance.
      </p>
      <span
        :class="gpsSetup ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
        class="text-xs px-2 py-1 rounded-full inline-block"
      >
        {{ gpsSetup ? 'Configured' : 'Not Set' }}
      </span>
    </div>

    <!-- Wi-Fi Attendance -->
    <div
      class="p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 transition hover:shadow-xl cursor-pointer"
      @click="router.visit('/wifi')"
    >
      <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-semibold text-green-700 dark:text-green-300">Wi-Fi Attendance</h3>
        <component
          :is="wifiSetup ? CheckCircle : AlertCircle"
          class="w-5 h-5"
          :class="wifiSetup ? 'text-green-500' : 'text-yellow-500'"
        />
      </div>
      <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
        Set and track attendance using Wi-Fi networks.
      </p>
      <span
        :class="wifiSetup ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
        class="text-xs px-2 py-1 rounded-full inline-block"
      >
        {{ wifiSetup ? 'Configured' : 'Not Set' }}
      </span>
    </div>

    <!-- Manual Attendance -->
    <div
      class="p-6 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 transition hover:shadow-xl cursor-pointer"
      @click="router.visit('/manual-attendance')"
    >
      <div class="flex items-center justify-between mb-2">
        <h3 class="text-lg font-semibold text-yellow-700 dark:text-yellow-300">Manual Attendance</h3>
        <component
          :is="manualSetup ? CheckCircle : AlertCircle"
          class="w-5 h-5"
          :class="manualSetup ? 'text-green-500' : 'text-yellow-500'"
        />
      </div>
      <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">
        Approve or manage manual attendance requests.
      </p>
      <span
        :class="manualSetup ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'"
        class="text-xs px-2 py-1 rounded-full inline-block"
      >
        {{ manualSetup ? 'Configured' : 'Not Set' }}
      </span>
    </div>
  </div>

      <!-- 🔹 Recent Attendance Table -->
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
