<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem, type User } from '@/types'
import { computed } from 'vue'
const page = usePage()
const users = computed(() => usePage().props.users?.data ?? [])
const pagination = computed(() => usePage().props.users)
const filters = ref({ ...page.props.filters })

const isLoading = ref(false)

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Users List', href: '/users' }
]

function goToCreate() {
  router.visit('/users/create')
}

function goToEdit(id: number) {
  router.visit(`/users/${id}/edit`)
}

function deleteUser(id: number) {
  if (confirm('Are you sure you want to delete this user?')) {
    router.delete(`/users/${id}`)
  }
}

function toggleStatus(user: User) {
  router.put(`/users/${user.id}/status`, {
    status: user.status === 1 ? 0 : 1
  }, {
    preserveScroll: true,
    preserveState: true
  })
}

function resetFilters() {
  filters.value = { search: '', status: '' }
  router.get('/users', filters.value, {
    preserveState: true,
    replace: true,
  })
}
watch(filters, async (newFilters) => {
  isLoading.value = true
  await router.get('/users', newFilters, {
    preserveState: true,
    replace: true,
    onFinish: () => (isLoading.value = false)
  })
}, { deep: true })
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Users List" />

    <div class="p-6 space-y-6">
      <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">User List</h2>
        <div class="flex gap-2">
          <a href="/users/export"
            class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded shadow">
            Export Excel
          </a>
          <button @click="goToCreate"
            class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded shadow">
            Add New
          </button>
        </div>
      </div>

      <!-- Filters -->
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <input
          type="text"
          v-model="filters.search"
          placeholder="Search name or email"
          class="p-2 border rounded w-full"
        />

        <select v-model="filters.status" class="p-2 border rounded w-full bg-white dark:bg-gray-900">
            <option value="">All Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
            </select>



        <button @click="resetFilters" class="text-sm underline text-gray-600">Reset Filters</button>
      </div>

      <!-- Loading -->


      <!-- User Table -->
      <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded bg-white dark:bg-gray-900">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
              <th class="px-6 py-3 text-left font-bold">S.No.</th>
              <th class="px-6 py-3 text-left font-bold">Name</th>
              <th class="px-6 py-3 text-left font-bold">Email</th>
              <th class="px-6 py-3 text-left font-bold">Status</th>
              <th class="px-6 py-3 text-left font-bold">Actions</th>
            </tr>
          </thead>
          <!-- <div v-if="isLoading" class="text-center py-6 text-gray-500">...</div> -->
          <tbody   >
            <tr v-for="(user, index) in users" :key="user.id" class="border-t dark:border-gray-700">
              <td class="px-6 py-4">{{ index + 1 }}</td>
              <td class="px-6 py-4">{{ user.name }}</td>
              <td class="px-6 py-4">{{ user.email }}</td>
              <td class="px-6 py-4">
                <label class="inline-flex items-center cursor-pointer">
                    <input
                    type="checkbox"
                    class="sr-only peer"
                    :checked="user.status == 1"
                    @change="toggleStatus(user)"
                    />
                    <div
                    class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-green-500 transition-all"
                    ></div>
                    <div
                    class="absolute ml-1 mt-0.5 h-5 w-5 bg-white rounded-full shadow transform transition-transform peer-checked:translate-x-5"
                    ></div>
                    <span class="ml-3 text-sm text-gray-600 dark:text-gray-300">
                    {{ user.status == 1 ? 'Active' : 'Inactive' }}
                    </span>
                </label>
                </td>

               <td class="px-6 py-4 flex gap-2">
                <button
                    @click="goToEdit(user.id)"
                    class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-md transition"
                >
                    Edit
                </button>
                <button
                    @click="deleteUser(user.id)"
                    class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-sm rounded-md transition"
                >
                    Delete
                </button>
                </td>


            </tr>
          </tbody>
        </table>
      </div>

         <!-- Pagination -->
      <div class="flex justify-center mt-4 space-x-2">
        <button
          v-for="link in users.links"
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
