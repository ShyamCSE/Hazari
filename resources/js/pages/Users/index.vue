<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { type BreadcrumbItem, type User } from '@/types'

const page = usePage()
const users = page.props.users?.data ?? []
const pagination = page.props.users
const filters = ref({ ...page.props.filters })

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
    status: user.status === 'active' ? 'inactive' : 'active'
  })
}

watch(filters, (newFilters) => {
  router.get('/users', newFilters, {
    preserveState: true,
    replace: true,
  })
}, { deep: true })
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <Head title="Users List" />

    <div class="p-6">
      <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">User List</h2>
        <button @click="goToCreate" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium px-4 py-2 rounded shadow">
          Add New
        </button>
      </div>

      <!-- Filter Bar -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <input
          type="text"
          v-model="filters.search"
          placeholder="Search by name or email"
          class="p-2 border rounded w-full"
        />

        <select v-model="filters.status" class="p-2 border rounded w-full">
          <option value="">All Status</option>
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>

        <select v-model="filters.type" class="p-2 border rounded w-full">
          <option value="">All Roles</option>
          <option value="1">Admin</option>
          <option value="0">User</option>
        </select>
      </div>
<a
  href="/users/export"
  class="bg-green-600 hover:bg-green-700 text-white text-sm font-medium px-4 py-2 rounded shadow mb-4 inline-block"
>
  Export to Excel
</a>
      <!-- User Table -->
      <div class="overflow-x-auto rounded border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
              <th class="px-6 py-3 text-left font-bold">ID</th>
              <th class="px-6 py-3 text-left font-bold">Name</th>
              <th class="px-6 py-3 text-left font-bold">Email</th>
              <th class="px-6 py-3 text-left font-bold">Status</th>
              <th class="px-6 py-3 text-left font-bold">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id" class="border-t dark:border-gray-700">
              <td class="px-6 py-4">{{ user.id }}</td>
              <td class="px-6 py-4">{{ user.name }}</td>
              <td class="px-6 py-4">{{ user.email }}</td>
              <td class="px-6 py-4">
                <span :class="user.status === 'active' ? 'text-green-600' : 'text-red-600'">{{ user.status }}</span>
              </td>
              <td class="px-6 py-4 flex space-x-2">
                <button @click="goToEdit(user.id)" class="text-blue-600 hover:underline">Edit</button>
                <button @click="deleteUser(user.id)" class="text-red-600 hover:underline">Delete</button>
                <button @click="toggleStatus(user)" class="text-yellow-600 hover:underline">
                  {{ user.status === 'active' ? 'Deactivate' : 'Activate' }}
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="flex justify-center mt-6 space-x-2">
        <template v-for="link in pagination.links" :key="link.label">
          <button
            v-if="link.url"
            @click="router.visit(link.url)"
            :class="[
              'px-3 py-1 rounded text-sm',
              link.active ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
            ]"
            v-html="link.label"
          ></button>
        </template>
      </div>
    </div>
  </AppLayout>
</template>
