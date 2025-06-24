<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const { locations } = usePage().props

function goToCreate() {
  router.visit('/gps-attendance/create')
}
</script>

<template>
  <AppLayout :breadcrumbs="[{ title: 'GPS Locations', href: '/gps' }]">
    <div class="p-6">
      <div class="flex justify-between mb-4">
        <h2 class="text-xl font-semibold">GPS Locations</h2>
        <button @click="goToCreate" class="px-4 py-2 bg-indigo-600 text-white rounded">Add New</button>
      </div>

      <table class="w-full text-sm border">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2">Location</th>
            <th class="p-2">Latitude</th>
            <th class="p-2">Longitude</th>
            <th class="p-2">Radius (m)</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="loc in locations.data" :key="loc.id">
            <td class="p-2">{{ loc.location_name }}</td>
            <td class="p-2">{{ loc.latitude }}</td>
            <td class="p-2">{{ loc.longitude }}</td>
            <td class="p-2">{{ loc.radius }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>
