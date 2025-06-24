<script setup lang="ts">
import L from 'leaflet'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { ref, onMounted } from 'vue'

const form = useForm({
  location_name: '',
  latitude: '',
  longitude: '',
  radius: 100
})

const map = ref(null)
const marker = ref(null)

function submit() {
  form.post('/gps-attendance')
}

// Try to get current location
function getCurrentLocation() {
  if ('geolocation' in navigator) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        form.latitude = position.coords.latitude.toFixed(6)
        form.longitude = position.coords.longitude.toFixed(6)
        setMapLocation(form.latitude, form.longitude)
      },
      (err) => {
        if (err.code === 1) {
          if (confirm("Location access denied. Would you like to enable it and try again?")) {
            // Give user time to change permissions
            setTimeout(() => getCurrentLocation(), 5000)
          }
        } else {
          alert("Unable to access location. Please try again.")
        }
      }
    )
  } else {
    alert("Geolocation is not supported in your browser.")
  }
}


// Setup the Leaflet map
function setMapLocation(lat, lng) {
  if (!map.value) {
    map.value = L.map('map').setView([lat, lng], 16)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map.value)

    marker.value = L.marker([lat, lng], { draggable: true }).addTo(map.value)
    marker.value.on('dragend', () => {
      const pos = marker.value.getLatLng()
      form.latitude = pos.lat.toFixed(6)
      form.longitude = pos.lng.toFixed(6)
    })
  } else {
    map.value.setView([lat, lng], 16)
    marker.value.setLatLng([lat, lng])
  }
}

onMounted(() => {
  getCurrentLocation()
})
</script>

<template>
  <AppLayout :breadcrumbs="[{ title: 'Add GPS Location', href: '/admin/gps/create' }]">
    <div class="max-w-3xl mx-auto p-6 bg-white dark:bg-zinc-900 rounded-2xl shadow-md transition">
      <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-white">📍 Add GPS Location</h2>

      <div class="mb-4 text-sm text-gray-600 dark:text-gray-300">
        This GPS location will be used to validate user check-ins. Drag the pin or use the current location button.
      </div>

      <form @submit.prevent="submit" class="space-y-6">
        <!-- Location Name -->
        <div>
          <label for="location_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Location Name</label>
          <input
            v-model="form.location_name"
            id="location_name"
            type="text"
            placeholder="e.g., Office Front Gate"
            class="mt-1 w-full rounded-xl border border-gray-300 dark:border-zinc-700 px-4 py-2 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
          />
        </div>

        <!-- Latitude & Longitude -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Latitude</label>
            <input
              v-model="form.latitude"
              id="latitude"
              type="number"
              step="any"
              placeholder="e.g., 28.6139"
              class="mt-1 w-full rounded-xl border border-gray-300 dark:border-zinc-700 px-4 py-2 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
          <div>
            <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Longitude</label>
            <input
              v-model="form.longitude"
              id="longitude"
              type="number"
              step="any"
              placeholder="e.g., 77.2090"
              class="mt-1 w-full rounded-xl border border-gray-300 dark:border-zinc-700 px-4 py-2 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
            />
          </div>
        </div>

        <!-- Radius -->
        <div>
          <label for="radius" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Radius (in meters)</label>
          <input
            v-model="form.radius"
            id="radius"
            type="number"
            min="10"
            max="1000"
            placeholder="e.g., 150"
            class="mt-1 w-full rounded-xl border border-gray-300 dark:border-zinc-700 px-4 py-2 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
          />
          <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Set the radius within which check-in is allowed.</p>
        </div>

        <!-- Map -->
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Choose on Map</label>
          <div id="map" class="w-full h-64 rounded-xl border border-gray-300 dark:border-zinc-700"></div>
          <button
            type="button"
            @click="getCurrentLocation"
            class="mt-2 text-sm text-indigo-600 dark:text-indigo-400 hover:underline"
          >
            Use my current location
          </button>
        </div>

        <!-- Submit Button -->
        <div>
          <button
            type="submit"
            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-xl font-medium transition"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Saving...' : 'Save Location' }}
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<!-- Add Leaflet Styles -->
<style>
@import "https://unpkg.com/leaflet@1.9.3/dist/leaflet.css";

.leaflet-container {
  border-radius: 0.75rem;
}
</style>

