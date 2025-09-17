<script setup>
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'

import StatusBadge from '../StatusBadge.vue'

const props = defineProps({
  tickets: Array,
  statuses: Array,
  users: Array,
  areas: Array,
})

const page = usePage()
const tickets = computed(() => props.tickets ?? page.props?.tickets ?? [])
const statuses = computed(() => props.statuses ?? page.props?.statuses ?? [])
const users = computed(() => props.users ?? page.props?.users ?? [])
const areas = computed(() => props.areas ?? page.props?.areas ?? [])

const filteredTickets = computed(() =>
  (tickets.value || []).filter(t => Number(t.status_id) === 1)
)

function getAreaName(areaId) {
  const area = areas.value.find((area) => area.id === areaId);
  return area ? area.name : "N/A";
}
function getUserName(userId) {
  const user = users.value.find((user) => user.id === userId);
  return user ? user.name : "N/A";
}

</script>

<template>
  <div>
    <h2>Lista Ticket in attesa</h2>
    <div class="row">
      <div v-for="ticket in filteredTickets" :key="ticket.id" class="col-md-4 mb-4">
        <Link :href="`/tickets/${ticket.id}/edit`" class="text-decoration-none text-dark">

        <div class="card h-100">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <span>
                Ticket #{{ ticket.id }}
              </span>
              <StatusBadge :status-id="ticket.status_id" :statuses="statuses" size="fs-6" />
            </div>

          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ ticket.description }}</h5>
            <p class="card-text mb-1"><strong>Area:</strong> {{ getAreaName(ticket.area_id) }}</p>
            <p class="card-text mb-1"><strong>Utente:</strong> {{ getUserName(ticket.user_id) }}</p>
            <div class="mt-auto">
              <p class="card-text"><small class="text-muted">Creato il: {{ new
                Date(ticket.created_at).toLocaleString() }}</small></p>
            </div>
          </div>

        </div>

        </Link>

      </div>
    </div>
  </div>
</template>