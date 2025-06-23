<script setup>
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const form = useForm({
  location_name: '',
  latitude: '',
  longitude: '',
  radius: 100
})

function submit() {
  form.post('/admin/gps')
}
</script>

<template>
  <AppLayout :breadcrumbs="[{ title: 'Add GPS Location', href: '/admin/gps/create' }]">
    <div class="p-6 max-w-lg">
      <h2 class="text-xl mb-4 font-bold">Add GPS Location</h2>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block">Location Name</label>
          <input v-model="form.location_name" class="input" type="text" />
        </div>
        <div>
          <label class="block">Latitude</label>
          <input v-model="form.latitude" class="input" type="number" step="any" />
        </div>
        <div>
          <label class="block">Longitude</label>
          <input v-model="form.longitude" class="input" type="number" step="any" />
        </div>
        <div>
          <label class="block">Radius (in meters)</label>
          <input v-model="form.radius" class="input" type="number" min="10" max="1000" />
        </div>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded" type="submit">Save</button>
      </form>
    </div>
  </AppLayout>
</template>
