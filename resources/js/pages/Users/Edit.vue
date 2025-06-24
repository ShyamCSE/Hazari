<script setup lang="ts">
import { useForm, Head, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import InputError from '@/components/InputError.vue'
import { usePage } from '@inertiajs/vue3'
import { type User } from '@/types'

const page = usePage<{ user: User }>()
const user = page.props.user

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Edit Users', href: '/edit' }
]

const form = useForm({
    name: user.name,
    email: user.email,
})

function submit() {
    form.put(route('users.update', user.id))
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">

        <Head title="Edit User" />

      <div class="w-full max-w-3xl mx-auto p-6 md:p-10 bg-white dark:bg-gray-900 rounded-2xl shadow space-y-6">
            <h2 class="text-2xl font-bold">Edit User</h2>

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

            <Button @click="submit" :disabled="form.processing">Update</Button>
        </div>
    </AppLayout>
</template>
