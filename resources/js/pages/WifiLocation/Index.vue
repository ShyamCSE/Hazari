<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const { locations } = usePage().props

function goToCreate() {
  router.visit('/wifi-attendance/create')
}
</script>

<template>
  <AppLayout :breadcrumbs="[{ title: 'Wi-Fi Locations', href: '/admin/wifi' }]">
    <div class="p-6">
      <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">Wi-Fi Locations</h2>
        <button @click="goToCreate" class="px-4 py-2 bg-indigo-600 text-white rounded">Add New</button>
      </div>

      <table class="w-full text-sm border">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2">SSID</th>
            <th class="p-2">Location</th>
            <th class="p-2">MAC</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="loc in locations.data" :key="loc.id">
            <td class="p-2">{{ loc.ssid }}</td>
            <td class="p-2">{{ loc.location_name }}</td>
            <td class="p-2">{{ loc.mac_address ?? '-' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
