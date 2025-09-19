<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';

const props = defineProps({
  tickets: Array,
  areas: Array,
  userLog: Object,
  statuses: Array,
  technicians: Array,
  userName: Array,
  projects: Array,
});

const getAreaName = (areaId) => {
  const area = props.areas.find((area) => area.id === areaId);
  return area ? area.name : "N/A";
};

const getUserName = (userId) => {
  const user = props.userName.find((name, index) => index + 1 === userId);
  return user || "N/A";
};

const getProjectName = (projectId) => {
  const project = props.projects.find((project) => project.id === projectId);
  return project ? project.name : "N/A";
};

const getTechnicianName = (technicianId) => {
  const technician = props.technicians.find(
    (tech) => tech.id === technicianId
  );
  return technician ? technician.name : "N/A";
};

const deleteTicket = (ticketId) => {
  if (confirm("Sei sicuro di voler eliminare questo ticket?")) {
    router.delete(route("tickets.destroy", ticketId));
  }
};
</script>


<template>

  <Head title="Tickets">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </Head>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="fs-4 fw-semibold"><i class="fa-solid fa-ticket"></i> Gestione Tickets</h2>
    </template>

    <div class="container mt-5">
      <div class="d-flex justify-content-end mb-4">
        <div>
          <Link href="/tickets/archive" class="btn btn-outline-secondary">
          <i class="fa-solid fa-box-archive"></i> Archivio Ticket
          </Link>
        </div>
      </div>

      <div class="card shadow">
        <div class="card-body p-0">
          <table class="table table-striped table-hover mb-0 p-3">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Progetto</th>
                <th>Area</th>
                <th>Stato</th>
                <th>Utente</th>
                <th>Tecnico</th>
                <th>Data</th>
                <th>Azioni</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="ticket in props.tickets" :key="ticket.id">
                <td>{{ ticket.id }}</td>
                <td>{{ getProjectName(ticket.project_id) }}</td>
                <td>{{ getAreaName(ticket.area_id) }}</td>
                <td>
                  <StatusBadge :status-id="ticket.status_id" :statuses="props.statuses" size="fs-6" />
                </td>
                <td>{{ getUserName(ticket.user_id) }}</td>
                <td>{{ getTechnicianName(ticket.assigned_to) || 'Non assegnato' }}</td>
                <td>{{ new Date(ticket.created_at).toLocaleDateString() }}</td>
                <td>
                  <div class="d-flex gap-2">
                    <Link :href="route('tickets.show', ticket.id)" class="btn btn-sm btn-primary" title="Visualizza">
                    <i class="fas fa-eye"></i>
                    </Link>
                    <Link :href="route('tickets.edit', ticket.id)" class="btn btn-sm btn-warning" title="Modifica">
                    <i class="fas fa-pencil-alt"></i>
                    </Link>
                    <button class="btn btn-sm btn-danger" @click="deleteTicket(ticket.id)" title="Elimina">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="props.tickets.length === 0">
                <td colspan="9" class="text-center text-muted py-4">Nessun ticket trovato</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
