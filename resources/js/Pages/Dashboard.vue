<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

// Dichiari che ti aspetti userLog come prop
const props = defineProps({
  tickets: Array,
  userLog: Object,
});
const role = props.userLog?.role_id ?? '—';

</script>

<template>

  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="fs-4 fw-semibold text-dark">Dashboard</h2>
    </template>

    <div class="py-4">
      <div class="container-fluid container-lg">
        <div class="row">
          <div class="col-4">
            PROFILO UTENTE
            <div>{{ props.userLog?.name ?? '—' }}</div>
          </div>

          <div class="col-7">
            <div class="card shadow-sm rounded">
              <div class="d-flex p-4 text-dark align-items-center justify-content-between">
                <h3 class="mb-4">I tuoi Ticket</h3>
                <PrimaryButton>
                  <Link href="/tickets/create" class="text-white text-decoration-none">
                  + Nuovo Ticket
                  </Link>
                </PrimaryButton>
              </div>
              <div class="ticket_list">
                <ul v-for="ticket in tickets" :key="ticket.id" class="list-unstyled mb-0">
                  <li>{{ ticket.description }}</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
