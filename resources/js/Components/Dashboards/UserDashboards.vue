<script setup>
import { Link } from '@inertiajs/vue3';



//Components
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';

const props = defineProps({
  tickets: Array,
  userLog: Object,
  statuses: Array,
  comments: Array,
});

const ticketComments = (ticketId) =>
  (props.comments || []).filter(c => c.ticket_id === ticketId);
</script>

<template>
  <div class="card shadow-sm rounded">
    <div class="d-flex p-4 text-dark align-items-center justify-content-between">
      <h3 class="mb-4">I tuoi Ticket</h3>
      <!-- New Ticket -->
      <PrimaryButton>
        <Link href="/tickets/create" class="btn-link text-decoration-none ">
        +<i class="fas fa-ticket-alt me-2"></i>Nuovo Ticket
        </Link>
      </PrimaryButton>
    </div>
    <hr>

    <!-- Tickets List -->
    <div class="ticket_list p-3">

      <div class="accordion" id="TicketAccordion">
        <div v-for="ticket in props.tickets" :key="ticket.id" class="accordion-item">
          <h2 class="accordion-header" :id="`heading-${ticket.id}`">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
              :data-bs-target="`#collapse-${ticket.id}`" aria-expanded="false" :aria-controls="`collapse-${ticket.id}`">
              <div class="badge">
                <StatusBadge :status-id="ticket.status_id" :statuses="statuses" size="fs-6" />
              </div>
              <div class="description">
                {{ ticket.description }}
              </div>
            </button>
          </h2>


          <div :id="`collapse-${ticket.id}`" class="accordion-collapse collapse" data-bs-parent="#TicketAccordion"
            :aria-labelledby="`heading-${ticket.id}`">
            <div class="accordion-body">
              <div class=" comments mt-4">
                <div v-if="ticketComments(ticket.id).length">
                  <div v-for="comment in ticketComments(ticket.id)" :key="comment.id"
                    class="comment p-2 mb-2 border rounded">
                    <p>
                      <strong>{{ comment.user.name }}:</strong>
                      {{ comment.content }}
                    </p>
                    <small class="text-muted">{{ new Date(comment.created_at).toLocaleString() }}</small>
                  </div>
                </div>
                <div v-else>
                  <p>Nessun commento per questo ticket.</p>
                </div>
              </div>
              <hr>
              <div class=" mt-3 text-center">
                <Link :href="`/tickets/${ticket.id}`" class=" text-decoration-none">
                Vedi Dettagli
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>


  </div>
</template>

<style>
.accordion {
  --bs-accordion-btn-focus-box-shadow: none;
  --bs-accordion-active-bg: #00285B;
  --bs-accordion-active-color: #ffffff;
}
</style>