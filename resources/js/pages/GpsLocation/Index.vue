<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const { locations } = usePage().props

function goToCreate() {
  router.visit('/gps-attendance/create')
}

function toggleStatus(loc){
  console.log()
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
            <th class="px-6 py-3 text-left font-bold">S.No.</th>
            <th class="px-6 py-3 text-left font-bold">Location</th>
            <th class="px-6 py-3 text-left font-bold">Latitude</th>
            <th class="px-6 py-3 text-left font-bold">Longitude</th>
            <th class="px-6 py-3 text-left font-bold">Radius (m)</th>
            <th class="px-6 py-3 text-left font-bold">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(loc , index ) in locations.data" :key="loc.id">
                <td class="px-6 py-4">{{ index +1 }}</td>
            <td class="px-6 py-4">{{ loc.location_name }}</td>
            <td class="px-6 py-4">{{ loc.latitude }}</td>
            <td class="px-6 py-4">{{ loc.longitude }}</td>
            <td class="px-6 py-4">{{ loc.radius }}</td>
               <td class="px-6 py-4 flex gap-2">
                 <input
                    type="checkbox"
                    class="sr-only peer"
                    :checked="loc.status == 1"
                    @change="toggleStatus(loc)"
                    />
                    <div
                    class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-green-500 transition-all"
                    ></div>
                    <div
                    class="absolute ml-1 mt-0.5 h-5 w-5 bg-white rounded-full shadow transform transition-transform peer-checked:translate-x-5"
                    ></div>

                <button
                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md transition"
                >
                    Edit
                </button>
                <button

                    class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md transition"
                >
                    Delete
                </button>
                </td>
          </tr>
        </tbody>
      </table>
          <!-- Pagination -->
      <div class="flex justify-center mt-4 space-x-2">
        <button
          v-for="link in locations.links"
          :key="link.label"
          v-html="link.label"
          @click="link.url && router.visit(link.url)"
          :class="[
            'px-3 py-1 rounded',
            link.active ? 'bg-indigo-600 text-white' : 'bg-gray-200 hover:bg-gray-300'
          ]"
        />
      </div>
    </div>
  </AppLayout>
</template>
