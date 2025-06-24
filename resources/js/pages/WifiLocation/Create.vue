<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { ref } from 'vue'
import InputError from '@/components/InputError.vue'
const form = useForm({
  ssid: '',
  location_name: '',
  mac_address: '',
  contact_person: '',
  contact_email: '',
  notes: '',
})

const showMore = ref(false)

function submit() {
  form.post('/wifi-attendance')
  console.log(form.errors);
}
</script>

<template>
  <AppLayout :breadcrumbs="[{ title: 'Add Wi-Fi Location', href: '/admin/wifi/create' }]">
    <div class="max-w-xl mx-auto p-6 bg-white rounded-2xl shadow-md">
      <h2 class="text-2xl font-semibold mb-6 text-gray-800">Add Wi-Fi Location</h2>

      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label for="ssid" class="block text-sm font-medium text-gray-700">SSID</label>
          <input
            v-model="form.ssid"
            id="ssid"
            type="text"
            placeholder="e.g., Office_WiFi_1"
            class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500"
          />
            <InputError :message="form.errors.ssid" />
        </div>

        <div>
          <label for="location_name" class="block text-sm font-medium text-gray-700">Location Name</label>
          <input
            v-model="form.location_name"
            id="location_name"
            type="text"
            placeholder="e.g., HQ - 2nd Floor"
            class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500"
          />
           <InputError :message="form.errors.location_name" />
        </div>

        <div>
          <label for="mac_address" class="block text-sm font-medium text-gray-700">
            MAC Address <span class="text-gray-400 text-xs">(optional)</span>
          </label>
          <input
            v-model="form.mac_address"
            id="mac_address"
            type="text"
            placeholder="e.g., 00:1A:2B:3C:4D:5E"
            class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500"
          />
           <InputError :message="form.errors.mac_address" />
        </div>

        <div>
          <button
            type="button"
            class="text-indigo-600 text-sm underline"
            @click="showMore = !showMore"
          >
            {{ showMore ? 'Hide Extra Fields' : 'Add More Details (optional)' }}
          </button>
        </div>

        <div v-if="showMore" class="grid gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Contact Person</label>
            <input
              v-model="form.contact_person"
              type="text"
              placeholder="e.g., Rajesh Kumar"
              class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Contact Email</label>
            <input
              v-model="form.contact_email"
              type="email"
              placeholder="e.g., rajesh@company.com"
              class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700">Notes</label>
            <textarea
              v-model="form.notes"
              rows="3"
              placeholder="Any specific instructions or remarks..."
              class="mt-1 w-full rounded-xl border border-gray-300 px-4 py-2 focus:border-indigo-500 focus:ring-indigo-500"
            ></textarea>
          </div>
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
