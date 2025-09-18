<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import TicketCard from '../TicketCard.vue'

const props = defineProps({
  tickets: Array,
  statuses: Array,
  users: Array,
  areas: Array,
})

const page = usePage()


const tickets = computed(() => props.tickets ?? page.props?.tickets ?? [])

const currentUserId = computed(() =>
  Number(page.props?.auth?.user?.id)
)

const filteredTickets = computed(() =>
  tickets.value.filter(t => Number(t.status_id) === 1)
)

const technicianTickets = computed(() =>
  tickets.value.filter(t =>
    Number(t.assigned_to ?? t.technician_id) === currentUserId.value
  )
)

</script>

<template>
  <div>
    <h2>Ticket in attesa</h2>
    <div class="row flex-nowrap overflow-x-auto g-3 mb-5" style="max-height: 500px;">
      <div v-for="ticket in filteredTickets" :key="ticket.id" class="col mb-4">

        <TicketCard :ticket="ticket" :statuses="statuses" :users="users" :areas="areas" />
      </div>
    </div>
    <hr>

    <h2>
      Ticket assegnati
    </h2>
    <div class="row flex-nowrap overflow-x-auto" style="max-height: 500px;">
      <div v-for="ticket in technicianTickets" :key="ticket.id" class="col mb-4">

        <TicketCard :ticket="ticket" :statuses="statuses" :users="users" :areas="areas" />
      </div>
    </div>

  </div>
</template>