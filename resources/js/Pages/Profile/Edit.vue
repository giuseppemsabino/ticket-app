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
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Profile
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div>
          {{ user.name }}
        </div>

        <div class="bg-white p-4 shadow sm:rounded-lg sm:p-8">
          <UpdatePasswordForm class="max-w-xl" />
        </div>

      </div>
    </div>
  </AuthenticatedLayout>
</template>
