<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'

const form = useForm({
  ssid: '',
  location_name: '',
  mac_address: '',
})

function submit() {
  form.post('/admin/wifi')
}
</script>

<template>
  <AppLayout :breadcrumbs="[{ title: 'Add Wi-Fi Location', href: '/admin/wifi/create' }]">
    <div class="p-6 max-w-lg">
      <h2 class="text-xl mb-4 font-bold">Add Wi-Fi Location</h2>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block">SSID</label>
          <input v-model="form.ssid" class="input" type="text" />
        </div>
        <div>
          <label class="block">Location Name</label>
          <input v-model="form.location_name" class="input" type="text" />
        </div>
        <div>
          <label class="block">MAC Address (optional)</label>
          <input v-model="form.mac_address" class="input" type="text" />
        </div>
        <button class="px-4 py-2 bg-indigo-600 text-white rounded" type="submit">Save</button>
      </form>
    </div>
  </AppLayout>
</template>
