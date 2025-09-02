<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="fs-4 fw-semibold text-dark">
        Dashboard
      </h2>
    </template>

    <div class="py-4">
      <div class="container-fluid container-lg">
        <div class="card shadow-sm rounded">
          <div class="p-4 text-dark">
            <h3 class="mb-4">I tuoi Ticket</h3>

            <PrimaryButton>
              + Nuovo Ticket
            </PrimaryButton>

          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
