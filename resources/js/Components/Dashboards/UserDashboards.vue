<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';

const props = defineProps({
  tickets: Array,
  userLog: Object,
  statuses: Array,
  comments: Array
});

</script>

<template>
  <div class="card shadow-sm rounded">
    <div class="d-flex p-4 text-dark align-items-center justify-content-between">
      <h3 class="mb-4">I tuoi Ticket</h3>
      <!-- New Ticket -->
      <PrimaryButton>
        <Link href="/tickets/create" class="text-white text-decoration-none">
        + Nuovo Ticket
        </Link>
      </PrimaryButton>
    </div>
    <hr>

    <!-- Tickets List -->
    <div class="ticket_list p-3">

      <div class="accordion" id="TicketAccordion">
        <div v-for="ticket in props.tickets" :key="ticket.id" class="accordion-item">
          <h2 class="accordion-header" :id="`haeding-${ticket.id}`">
            <button class="accordion-button" type="button" data-bs-toggle="collapse"
              :data-bs-target="`#collapse-${ticket.id}`" aria-expanded="true" :aria-controls="`#collapse-${ticket.id}`">
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
              <div v-for="comment in props.comments" class="comments">
                {{ comment.content }}
              </div>
              <div class="text-end">
                <span class="text-muted">
                  Ultimo aggiornamento: {{ new Date(ticket.updated_at).toLocaleString() }}
                </span>
              </div>
              <div class="mt-3 text-end">
                <PrimaryButton>
                  <Link :href="`/tickets/${ticket.id}`" class="text-white text-decoration-none">
                  Vedi Dettagli
                  </Link>
                </PrimaryButton>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>


  </div>
</template>