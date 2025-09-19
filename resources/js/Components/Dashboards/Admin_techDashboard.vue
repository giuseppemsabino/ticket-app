<script setup>
import { computed, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import TicketCard from '../TicketCard.vue'
import TicketTable from '../TicketTable.vue'

const props = defineProps({
  tickets: Array,
  statuses: Array,
  users: Array,
  areas: Array,
})

const page = usePage()

const viewModeFiltered = ref('card')
const viewModeTechnichian = ref('card')
const showClosedTickets = ref(false) // Nuovo stato per controllare la visibilità dei ticket chiusi

const toogleViewModeFiltered = () => {
  viewModeFiltered.value = viewModeFiltered.value === 'card' ? 'list' : 'card'
}

const toogleViewModeTechnician = () => {
  viewModeTechnichian.value = viewModeTechnichian.value === 'card' ? 'list' : 'card'
}

const tickets = computed(() => props.tickets ?? page.props?.tickets ?? [])

const currentUserId = computed(() =>
  Number(page.props?.auth?.user?.id)
)

const filteredTickets = computed(() =>
  tickets.value.filter(t => Number(t.status_id) === 1)
)

const technicianTickets = computed(() =>
  tickets.value.filter(t =>
    Number(t.assigned_to ?? t.technician_id) === currentUserId.value &&
    Number(t.status_id) !== 3
  )
)

const closeTickets = computed(() =>
  tickets.value.filter(t => Number(t.status_id) === 3
  )
)

</script>

<template>
  <div>
    <div class="d-flex justify-content-between align-items-center mb-3">

      <h2>Ticket in attesa</h2>

      <div class="btn-group mb-3" role="group">
        <button class="btn" :class="viewModeFiltered === 'card' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="viewModeFiltered = 'card'" title="Vista a cards">
          <i class="fas fa-th-large"></i>
        </button>
        <button class="btn" :class="viewModeFiltered === 'list' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="viewModeFiltered = 'list'" title="Vista a lista">
          <i class="fas fa-list"></i>
        </button>
      </div>
    </div>


    <div v-if="viewModeFiltered === 'card'" class="cards">
      <div class="row flex-nowrap overflow-x-auto mb-5" style="max-height: 500px;">
        <div v-for="ticket in filteredTickets" :key="ticket.id" class="col-auto mb-4">

          <TicketCard :ticket="ticket" :statuses="statuses" :users="users" :areas="areas" />
        </div>
      </div>
    </div>

    <div v-else class="list-view rounded border shadow-sm p-3 mb-5 bg-body-tertiary">
      <TicketTable :tickets="filteredTickets" :statuses="statuses" :users="users" :areas="areas" />
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3">

      <h2>
        Ticket assegnati
      </h2>

      <div class="btn-group mb-3" role="group">
        <button type="button" class="btn"
          :class="viewModeTechnichian === 'card' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="viewModeTechnichian = 'card'" title="Vista a cards">
          <i class="fas fa-th-large"></i>
        </button>
        <button type="button" class="btn"
          :class="viewModeTechnichian === 'list' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="viewModeTechnichian = 'list'" title="Vista a lista">
          <i class="fas fa-list"></i>
        </button>
      </div>
    </div>


    <div v-if="viewModeTechnichian === 'card'" class="card-view">
      <div class="row flex-nowrap overflow-x-auto" style="max-height: 500px;">

        <div v-for="ticket in technicianTickets" :key="ticket.id" class="col-auto mb-4">
          <TicketCard :ticket="ticket" :statuses="statuses" :users="users" :areas="areas" />
        </div>

      </div>
    </div>

    <div v-else class="list-view rounded border shadow-sm p-3 mb-5 bg-body-tertiary">
      <TicketTable :tickets="technicianTickets" :statuses="statuses" :users="users" :areas="areas" />
    </div>

    <hr>

    <div v-if="closeTickets.length" class="d-flex gap-2 align-items-center mb-3">
      <h2>Ticket chiusi</h2>
      <button class="btn" @click="showClosedTickets = !showClosedTickets"
        :title="showClosedTickets ? 'Nascondi ticket chiusi' : 'Mostra ticket chiusi'">
        <i v-if="showClosedTickets" class="fas fa-chevron-up"></i>
        <span v-else>
          <i class="fas fa-chevron-down"></i>
          <span class="ms-1">( {{ closeTickets.length }} )</span>
        </span>
      </button>
    </div>

    <div v-if="showClosedTickets" class="list-view rounded border shadow-sm p-3 mb-5 bg-body-tertiary">
      <TicketTable :tickets="closeTickets" :statuses="statuses" :users="users" :areas="areas" />
    </div>

  </div>
</template>