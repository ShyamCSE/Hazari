<script setup lang="ts">
import { Head, usePage, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const page = usePage();
const attendances = page.props.attendances;
</script>

<template>
  <AppLayout :breadcrumbs="[{ title: 'Attendance Report', href: '/admin/attendance' }]">
    <Head title="Attendance Report" />
    <div class="p-6">
      <h2 class="text-2xl font-bold mb-4">Attendance Report</h2>

      <table class="w-full border text-sm">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-4 py-2 text-left">User</th>
            <th class="px-4 py-2 text-left">Date</th>
            <th class="px-4 py-2 text-left">Check In</th>
            <th class="px-4 py-2 text-left">Check Out</th>
            <th class="px-4 py-2 text-left">Method</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in attendances.data" :key="item.id" class="border-t">
            <td class="px-4 py-2">{{ item.user.name }}</td>
            <td class="px-4 py-2">{{ item.date }}</td>
            <td class="px-4 py-2">{{ item.check_in || '-' }}</td>
            <td class="px-4 py-2">{{ item.check_out || '-' }}</td>
            <td class="px-4 py-2 capitalize">{{ item.method }}</td>
          </tr>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="flex justify-center mt-4 space-x-2">
        <button
          v-for="link in attendances.links"
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
