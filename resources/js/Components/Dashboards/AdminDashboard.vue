<script setup>
import { computed, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

//Components
import TicketCard from '../TicketCard.vue'
import TicketTable from '../TicketTable.vue'

import { getProjectName } from '@/lib/utils'

const props = defineProps({
  tickets: Array,
  statuses: Array,
  users: Array,
  areas: Array,
  projects: Array,
});

const page = usePage()

const viewModeFiltered = ref('card')
const viewModeTechnichian = ref('card')
const viewModeUsers = ref('list')
const showClosedTickets = ref(false)
const selectedProjectId = ref(null)

const toogleViewModeFiltered = () => {
  viewModeFiltered.value = viewModeFiltered.value === 'card' ? 'list' : 'card'
}

const toogleViewModeTechnician = () => {
  viewModeTechnichian.value = viewModeTechnichian.value === 'card' ? 'list' : 'card'
}

const toogleViewModeUsers = () => {
  viewModeUsers.value = viewModeUsers.value === 'card' ? 'list' : 'card'
}

const tickets = computed(() => props.tickets ?? page.props?.tickets ?? [])
const projects = computed(() => props.projects ?? page.props?.projects ?? [])
const users = computed(() => props.users ?? page.props?.auth?.user ?? [])

const currentUserId = computed(() =>
  Number(page.props?.auth?.user?.id)
)

const filteredTickets = computed(() =>
  tickets.value.filter(t => {
    const filterStatus = Number(t.status_id) === 1;
    const filterProjectId = projects.value.some(p => p.id === t.project_id);
    const filterProjectName = selectedProjectId.value ? t.project_id === selectedProjectId.value : true;

    return filterStatus && filterProjectId && filterProjectName;
  })
)

const technicianTickets = computed(() =>
  tickets.value.filter(t => {
    const filtereTechniscian = Number(t.assigned_to ?? t.technician_id) === currentUserId.value &&
      Number(t.status_id) !== 3
    const filterProjectName = selectedProjectId.value ? t.project_id === selectedProjectId.value : true;

    return filtereTechniscian && filterProjectName
  })
)

const closeTickets = computed(() =>
  tickets.value.filter(t => Number(t.status_id) === 3)
)

const projectUsers = computed(() => {
  // Filtra gli utenti che sono assegnati ai progetti dell'admin
  // (questa è una simulazione, dovrai adattarla ai tuoi dati reali)
  return Array.isArray(users.value) ? users.value.filter(user => {
    // Se è selezionato un progetto specifico, filtra solo gli utenti di quel progetto
    if (selectedProjectId.value) {
      return user.projects && user.projects.some(p => p.id === selectedProjectId.value);
    }
    // Altrimenti mostra tutti gli utenti dei progetti dell'admin
    return true;
  }) : [];
});
</script>

<template>
  <div>
    <div class="mb-4">
      <div class="d-flex align-items-center gap-3">
        <h4 class="mb-0">Filtro progetto:</h4>
        <div class="d-flex align-items-center">
          <select v-model="selectedProjectId" class="form-select">
            <option :value="null">Tutti i progetti</option>
            <option v-for="project in projects" :key="project.id" :value="project.id">
              {{ project.name }}
            </option>
          </select>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Ticket in attesa</h2>

      <div class="btn-group mb-3" role="group">
        <button class="btn" :class="viewModeFiltered === 'card' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="toogleViewModeFiltered" title="Vista a cards">
          <i class="fas fa-th-large"></i>
        </button>
        <button class="btn" :class="viewModeFiltered === 'list' ? 'btn-secondary' : 'btn-outline-secondary'"
          @click="toogleViewModeFiltered" title="Vista a lista">
          <i class="fas fa-list"></i>
        </button>
      </div>
    </div>

    <div v-if="viewModeFiltered === 'card'" class="cards">
      <div class="row flex-nowrap overflow-x-auto mb-5" style="max-height: 500px;">
        <div v-for="ticket in filteredTickets" :key="ticket.id" class="col-auto mb-4">
          <TicketCard :ticket="ticket" :statuses="statuses" :users="users" :areas="areas" :projects="projects" />
        </div>
      </div>
    </div>

    <div v-else class="list-view rounded border shadow-sm p-3 mb-5 bg-body-tertiary">
      <TicketTable :tickets="filteredTickets" :statuses="statuses" :users="users" :areas="areas" :projects="projects" />
    </div>

    <hr>

    <div>


      <div v-if="viewModeTechnichian === 'card'" class="cards">
        <div class="row flex-nowrap overflow-x-auto mb-5" style="max-height: 500px;">
          <div v-for="ticket in technicianTickets" :key="ticket.id" class="col-auto mb-4">
            <TicketCard :ticket="ticket" :statuses="statuses" :users="users" :areas="areas" :projects="projects" />
          </div>
        </div>
      </div>

      <div v-else class="list-view rounded border shadow-sm p-3 mb-5 bg-body-tertiary">
        <TicketTable :tickets="technicianTickets" :statuses="statuses" :users="users" :areas="areas"
          :projects="projects" />
      </div>


      <!-- Sezione Utenti progetti -->
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Utenti progetti</h2>

        <div class="btn-group" role="group">
          <button type="button" class="btn"
            :class="viewModeUsers === 'card' ? 'btn-secondary' : 'btn-outline-secondary'" @click="toogleViewModeUsers"
            title="Vista a cards">
            <i class="fas fa-th-large"></i>
          </button>
          <button type="button" class="btn"
            :class="viewModeUsers === 'list' ? 'btn-secondary' : 'btn-outline-secondary'" @click="toogleViewModeUsers"
            title="Vista a lista">
            <i class="fas fa-list"></i>
          </button>
        </div>
      </div>

      <div class="list-view rounded border shadow-sm p-3 mb-5 bg-body-tertiary">
        <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">Nome</th>
              <th scope="col">Email</th>
              <th scope="col">Ruolo</th>
              <th scope="col">Progetti</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in projectUsers" :key="user.id">
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.role?.name || 'N/A' }}</td>
              <td>
                <span v-if="user.projects && user.projects.length">
                  {{user.projects.map(p => p.name).join(', ')}}
                </span>
                <span v-else>Nessun progetto</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <hr>

      <!-- Sezione Ticket chiusi -->
      <div v-if="closeTickets.length" class="d-flex gap-2 align-items-center mb-3">
        <h2>Ticket chiusi</h2>
        <button class="btn btn-outline-secondary" @click="showClosedTickets = !showClosedTickets"
          :title="showClosedTickets ? 'Nascondi ticket chiusi' : 'Mostra ticket chiusi'">
          <i v-if="showClosedTickets" class="fas fa-chevron-up"></i>
          <span v-else>
            <i class="fas fa-chevron-down"></i>
            <span class="ms-1">( {{ closeTickets.length }} )</span>
          </span>
        </button>
      </div>

      <div v-if="showClosedTickets" class="list-view rounded border shadow-sm p-3 mb-5 bg-body-tertiary">
        <TicketTable :tickets="closeTickets" :statuses="statuses" :users="users" :areas="areas" :projects="projects" />
      </div>
    </div>
  </div>
</template>



<style scoped></style>