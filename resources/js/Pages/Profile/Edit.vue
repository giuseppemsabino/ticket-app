<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';

import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage()

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const user = computed(() => page.props.auth.user)
</script>

<template>

  <Head title="Profile" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="fw-bold">
        Profilo
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-4">
        <div class="text-center mt-4 mb-8">
          <h1>{{ user.name }}</h1>
          <p class="text-sm text-gray-600">{{ user.email }}</p>
        </div>

        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
          <UpdatePasswordForm class="max-w-xl" />
        </div>

      </div>
    </div>
  </AuthenticatedLayout>
</template>
