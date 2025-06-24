<script setup lang="ts">
import L from 'leaflet'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { ref, onMounted, watch } from 'vue'
import InputError from '@/components/InputError.vue'
import FormInput from '@/components/FormInput.vue'
import 'leaflet-control-geocoder'


import 'leaflet-control-geocoder/dist/Control.Geocoder.css'

const form = useForm({
  location_name: '',
  latitude: '',
  longitude: '',
  radius: 100
})


const map = ref<L.Map | null>(null)
const marker = ref<L.Marker | null>(null)
const circle = ref<L.Circle | null>(null)


function submit() {
  form.post('/gps-attendance')
}

function getCurrentLocation() {
  if ('geolocation' in navigator) {
    navigator.geolocation.getCurrentPosition(
      (position) => {
        form.latitude = position.coords.latitude.toFixed(6)
        form.longitude = position.coords.longitude.toFixed(6)
        setMapLocation(parseFloat(form.latitude), parseFloat(form.longitude))
      },
      (err) => {
        if (err.code === 1) {
          if (confirm("Location access denied. Would you like to enable it and try again?")) {
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

function setMapLocation(lat: number, lng: number) {
  if (!map.value) {
    map.value = L.map('map').setView([lat, lng], 16)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap contributors'
    }).addTo(map.value)

    // Add marker
    marker.value = L.marker([lat, lng], { draggable: true }).addTo(map.value)
    marker.value.on('dragend', () => {
      const pos = marker.value!.getLatLng()
      form.latitude = pos.lat.toFixed(6)
      form.longitude = pos.lng.toFixed(6)
      updateCircle(pos.lat, pos.lng)
    })

    // Add circle
    circle.value = L.circle([lat, lng], {
      radius: Number(form.radius),
      color: 'blue',
      fillColor: '#3b82f6',
      fillOpacity: 0.2
    }).addTo(map.value)

    // ✅ Add geocoder after map is created
    // @ts-ignore
    L.Control.geocoder({
      defaultMarkGeocode: false
    })
    .on('markgeocode', function (e) {
      const latlng = e.geocode.center
      form.latitude = latlng.lat.toFixed(6)
      form.longitude = latlng.lng.toFixed(6)
      setMapLocation(latlng.lat, latlng.lng)
    })
    .addTo(map.value)

  } else {
    map.value.setView([lat, lng], 16)
    marker.value!.setLatLng([lat, lng])
    updateCircle(lat, lng)
  }
}


function updateCircle(lat: number, lng: number) {
  if (circle.value) {
    circle.value.setLatLng([lat, lng])
    circle.value.setRadius(Number(form.radius))
  }
}

watch(() => form.radius, (newRadius) => {
  const lat = parseFloat(form.latitude)
  const lng = parseFloat(form.longitude)
  if (!isNaN(lat) && !isNaN(lng)) {
    updateCircle(lat, lng)
  }
})

onMounted(() => {
  getCurrentLocation()
})
</script>

<template>
  <AppLayout :breadcrumbs="[{ title: 'Add GPS Location', href: '/admin/gps/create' }]">
    <div class="max-w-4xl mx-auto p-6 bg-white dark:bg-zinc-900 rounded-2xl shadow-md">
      <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-white">📍 Add GPS Location</h2>

      <p class="mb-4 text-sm text-gray-600 dark:text-gray-300">
        This location will be used to validate user check-ins. Drag the pin or use the current location button.
      </p>

      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label for="location_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Location Name</label>
          <input
            v-model="form.location_name"
            id="location_name"
            type="text"
            placeholder="e.g., Office Front Gate"
            class="mt-1 w-full rounded-xl border border-gray-300 dark:border-zinc-700 px-4 py-2 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
          />
          <InputError :message="form.errors.location_name" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label for="latitude" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Latitude</label>
            <input
              v-model="form.latitude"
              id="latitude"
              type="number"
              step="any"
              class="mt-1 w-full rounded-xl border border-gray-300 dark:border-zinc-700 px-4 py-2 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
            />
            <InputError :message="form.errors.latitude" />
          </div>

          <div>
            <label for="longitude" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Longitude</label>
            <input
              v-model="form.longitude"
              id="longitude"
              type="number"
              step="any"
              class="mt-1 w-full rounded-xl border border-gray-300 dark:border-zinc-700 px-4 py-2 bg-white dark:bg-zinc-800 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500"
            />
            <InputError :message="form.errors.longitude" />
          </div>
        </div>

            <FormInput
            id="radius"
            label="Radius (in meters)"
            type="number"
            :min="10"
            :max="1000"
            placeholder="e.g., 150"
            v-model="form.radius"
            :error="form.errors.radius"
            helper="Set the radius within which check-in is allowed."
            />


        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Choose on Map</label>
          <div id="map" class="w-full h-72 rounded-xl border border-gray-300 dark:border-zinc-700"></div>
          <button
            type="button"
            @click="getCurrentLocation"
            class="mt-2 text-sm text-indigo-600 dark:text-indigo-400 hover:underline"
          >
            Use my current location
          </button>
        </div>

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

<style>
@import "https://unpkg.com/leaflet@1.9.3/dist/leaflet.css";

.leaflet-container {
  border-radius: 0.75rem;
}
</style>
