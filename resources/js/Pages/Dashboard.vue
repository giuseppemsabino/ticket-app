<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import StatusBadge from '@/Components/StatusBadge.vue';
import { comment } from 'postcss';


const props = defineProps({
  tickets: Array,
  userLog: Object,
  statuses: Array,
  comments: Array
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
              <hr>

              <!-- Tickets List -->
              <div v-for="ticket in tickets" :key="ticket.id" class="ticket_list p-3">
                <div class="accordion" id={{ ticket.id }}>
                  <div class="accordion-item">
                    <h2 class="accordion-header d-flex justify-content-between align-items-center"
                      :id="'heading' + ticket.id">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class="title ">
                          {{ ticket?.description }}
                        </div>
                        <StatusBadge :status-id="ticket.status_id" :statuses="statuses" size="fs-6" />
                      </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent={{ ticket.id }}>
                      <div class="accordion-body">
                        <div v-for="comment in comments" :key="comment.id" class="mb-3 p-3 border rounded ">
                          {{ comment.content }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>