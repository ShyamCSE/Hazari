<script setup>
import { router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const { requests } = usePage().props

function handleAction(id, action) {
  router.put(`/admin/manual-attendance/${id}`, { status: action })
}
</script>

<template>
  <AppLayout :breadcrumbs="[{ title: 'Manual Requests', href: '/admin/manual-attendance' }]">
    <div class="p-6">
      <h2 class="text-2xl font-semibold mb-4">Manual Attendance Requests</h2>

      <table class="w-full text-sm border bg-white dark:bg-gray-900">
        <thead class="bg-gray-100 dark:bg-gray-800">
          <tr>
            <th class="p-2 text-left">User</th>
            <th class="p-2">Date</th>
            <th class="p-2">Time</th>
            <th class="p-2">Type</th>
            <th class="p-2">Reason</th>
            <th class="p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="req in requests.data" :key="req.id">
            <td class="p-2">{{ req.user.name }}</td>
            <td class="p-2">{{ req.date }}</td>
            <td class="p-2">{{ req.punch_time }}</td>
            <td class="p-2">{{ req.type }}</td>
            <td class="p-2">{{ req.reason }}</td>
            <td class="p-2 space-x-2">
              <button @click="handleAction(req.id, 'approved')" class="text-green-600 hover:underline">Approve</button>
              <button @click="handleAction(req.id, 'rejected')" class="text-red-600 hover:underline">Reject</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
