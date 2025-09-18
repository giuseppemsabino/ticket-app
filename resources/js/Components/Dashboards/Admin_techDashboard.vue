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
    Number(t.assigned_to ?? t.technician_id) === currentUserId.value
  )
)

</script>

<template>
  <div>
    <div class="d-flex justify-content-between align-items-center mb-3">

      <h2>Ticket in attesa</h2>

      <div class="btn-group  mb-3 " role="group">
        <button class="btn" :class="viewModeFiltered === 'card' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="viewModeFiltered = 'card'">
          &#10066;
        </button>
        <button class="btn" :class="viewModeFiltered === 'list' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="viewModeFiltered = 'list'">
          &#9776;
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

      <div class="btn-group  mb-3 " role="group">
        <button type="button" class="btn "
          :class="viewModeTechnichian === 'card' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="viewModeTechnichian = 'card'">
          &#10066;
        </button>
        <button type="button" class="btn"
          :class="viewModeTechnichian === 'list' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="viewModeTechnichian = 'list'">
          &#9776;
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

  </div>
</template>