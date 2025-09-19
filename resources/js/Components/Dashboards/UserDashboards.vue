<script setup>
import { Link } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

//Components
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';

//Props
const props = defineProps({
  tickets: Array,
  userLog: Object,
  statuses: Array,
  comments: Array,
});

const ticketComments = (ticketId) =>
  (props.comments || []).filter(c => c.ticket_id === ticketId && c.user_visibility);
</script>

<template>
  <div>

    <Head>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </Head>

    <div class="card shadow">
      <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <h3 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>I tuoi Ticket</h3>

        <!-- New Ticket -->
        <PrimaryButton>
          <Link href="/tickets/create" class="btn-link text-decoration-none">
          <i class="fas fa-plus me-1"></i><i class="fas fa-ticket-alt me-1"></i>Nuovo Ticket
          </Link>
        </PrimaryButton>
      </div>

      <!-- Tickets List -->
      <div class="ticket-list p-3">
        <div v-if="props.tickets && props.tickets.length > 0" class="accordion custom-accordion" id="TicketAccordion">
          <!-- Accordion Ticket -->
          <div v-for="ticket in props.tickets" :key="ticket.id" class="accordion-item mb-3 border rounded shadow-sm">

            <h2 class="accordion-header" :id="`heading-${ticket.id}`">
              <button class="accordion-button collapsed d-flex align-items-start" type="button"
                data-bs-toggle="collapse" :data-bs-target="`#collapse-${ticket.id}`" aria-expanded="false"
                :aria-controls="`collapse-${ticket.id}`">
                <div class="d-flex w-100 justify-content-between align-items-center">
                  <div class="d-flex align-items-center">
                    <div class="ticket-icon me-3">
                      <i class="fas fa-ticket  fs-4"></i>
                    </div>
                    <!-- Status -->
                    <div class="ticket-content">
                      <div class="d-flex align-items-center mb-1">
                        <span class="ticket-id me-2">#{{ ticket.id }}</span>
                        <StatusBadge :status-id="ticket.status_id" :statuses="statuses" size="fs-6" />
                      </div>
                      <!-- Description with limit -->
                      <div class="description text-dark">
                        {{ ticket.description && ticket.description.length > 100
                          ? ticket.description.substring(0, 100) + '...'
                          : ticket.description }}
                      </div>
                      <!-- Date/Time -->
                      <div class="ticket-meta mt-1">
                        <small class="text-muted">
                          <i class="far fa-calendar-alt me-1"></i>
                          {{ new Date(ticket.created_at).toLocaleString() }}
                        </small>
                        <!-- Comments count -->
                        <span v-if="ticketComments(ticket.id).length" class="ms-3 badge bg-info text-white">
                          <i class="far fa-comment-dots me-1"></i>
                          {{ ticketComments(ticket.id).length }} commenti
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="toggle-icon ms-2">
                    <i class="fas fa-chevron-down fa-fw"></i>
                  </div>
                </div>
              </button>
            </h2>
            <!-- Comments -->
            <div :id="`collapse-${ticket.id}`" class="accordion-collapse collapse" data-bs-parent="#TicketAccordion"
              :aria-labelledby="`heading-${ticket.id}`">
              <div class="accordion-body bg-light">
                <div class="comments mt-2 mb-3">
                  <h5 class="mb-3 d-flex align-items-center">
                    <i class="fas fa-comments me-2 text-primary"></i>Commenti
                  </h5>
                  <!-- Comments content and details -->
                  <div v-if="ticketComments(ticket.id).length" class="comments-container ps-2">
                    <div v-for="comment in ticketComments(ticket.id)" :key="comment.id"
                      class="comment p-3 mb-2 border rounded bg-white">
                      <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-user-circle me-2 text-secondary"></i>
                        <strong>{{ comment.user.name }}</strong>
                      </div>
                      <p class="mb-1 ms-4">{{ comment.content }}</p>
                      <div class="text-end">
                        <small class="text-muted">
                          <i class="far fa-clock me-1"></i>{{ new Date(comment.created_at).toLocaleString() }}
                        </small>
                      </div>
                    </div>
                  </div>
                  <div v-else class="text-center py-3 bg-white rounded border">
                    <i class="far fa-comment-dots text-muted d-block mb-2" style="font-size: 1.5rem;"></i>
                    <p class="text-muted mb-0">Nessun commento per questo ticket.</p>
                  </div>
                </div>
                <!-- View details -->
                <div class="d-flex justify-content-center mt-3">
                  <Link :href="`/tickets/${ticket.id}`" class="btn btn-outline-primary">
                  <i class="fas fa-eye me-2"></i>Vedi Dettagli
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Empty Case -->
        <div v-else class="text-center py-5">
          <i class="fas fa-ticket-alt text-muted mb-3" style="font-size: 3rem;"></i>
          <p class="h5 text-muted">Non ci sono ticket da mostrare</p>
          <p class="text-muted">Crea un nuovo ticket per iniziare</p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.custom-accordion .accordion-item {
  border-radius: 8px;
  overflow: hidden;
  transition: all 0.3s ease;
  border: 1px solid rgba(0, 0, 0, 0.125);
}

.custom-accordion .accordion-item:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
}

.custom-accordion .accordion-button {
  padding: 1rem;
  background-color: #fff;
  border: none;
}

.custom-accordion .accordion-button:not(.collapsed) {
  background-color: #f8f9fa;
  color: #0d6efd;
  box-shadow: none;
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.custom-accordion .accordion-button:focus {
  box-shadow: none;
  border-color: rgba(0, 0, 0, 0.125);
}

/* Hide Bootstrap's default accordion chevron */
.custom-accordion .accordion-button::after {
  display: none;
}

.custom-accordion .accordion-button .toggle-icon {
  transition: transform 0.3s ease;
}

.custom-accordion .accordion-button:not(.collapsed) .toggle-icon {
  transform: rotate(-180deg);
}

.custom-accordion .description {
  font-size: 0.95rem;
  line-height: 1.4;
}

.custom-accordion .ticket-id {
  font-weight: bold;
  color: #6c757d;
}

.comments-container {
  max-height: 250px;
  overflow-y: auto;
}

.comment {
  transition: all 0.2s ease;
}

.comment:hover {
  background-color: #f8f9fa !important;
  transform: translateY(-2px);
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.accordion-body {
  padding: 1.25rem;
  border-top: none;
}
</style>