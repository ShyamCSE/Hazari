<script setup lang="ts">
import { useForm, Head, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import InputError from '@/components/InputError.vue'
import { type BreadcrumbItem, type User } from '@/types'
const form = useForm({
    name: '',
    email: '',
    mobile:'',
    password:'',
    status: 'active',
})
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Create Users', href: '/create' }
]
function submit() {
    form.post(route('users.store'))
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Create User" />

        <div class="max-w-xxl mx-auto p-8 bg-white rounded-lg shadow space-y-8">
            <h2 class="text-2xl font-bold">Create User</h2>

            <div>
                <Label for="name">Name</Label>
                <Input v-model="form.name" id="name" type="text" />
                <InputError :message="form.errors.name" />
            </div>

            <div>
                <Label for="email">Email</Label>
                <Input v-model="form.email" id="email" type="email" />
                <InputError :message="form.errors.email" />
            </div>
            <div>
                <Label for="mobile">Mobile</Label>
                <Input v-model="form.mobile" id="mobile" type="number" />
                <InputError :message="form.errors.mobile" />
            </div>
            <div>
                <Label for="password">Password</Label>
                <Input v-model="form.password" id="password" type="password" />
                <InputError :message="form.errors.password" />
            </div>

            <Button @click="submit" :disabled="form.processing">Create</Button>
        </div>
    </AppLayout>
</template>
