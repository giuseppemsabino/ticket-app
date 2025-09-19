<script setup>
import { Head, Link, router } from "@inertiajs/vue3";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import StatusBadge from '@/Components/StatusBadge.vue';
import { getAreaName, getUserName, getTechnicianName } from '@/lib/utils';

const props = defineProps({
  tickets: Array,
  areas: Array,
  userLog: Object,
  statuses: Array,
  technicians: Array,
  projects: Array,
});

const getProjectName = (projectId) => {
  const project = props.projects.find((project) => project.id === projectId);
  return project ? project.name : "N/A";
};

const forceDeleteTicket = (ticketId) => {
  if (confirm("Sei sicuro di voler eliminare definitivamente questo ticket?")) {
    router.delete(route('tickets.forceDestroy', ticketId));
  }
};

const restore = (ticketId) => {
  router.get(route('tickets.restore', ticketId));
};
</script>

<template>

  <Head title="Archivio Tickets">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </Head>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="fs-4 fw-semibold"><i class="fa-solid fa-box-archive"></i> Archivio Tickets</h2>
    </template>

    <div class="container mt-5">
      <div class="d-flex justify-content-end mb-4">
        <div>
          <Link href="/tickets" class="btn btn-outline-primary" title="Torna ai Ticket Attivi">
          <i class="fas fa-arrow-left me-2"></i>Torna ai Ticket Attivi
          </Link>
        </div>
      </div>

      <div class="card shadow">
        <div class="card-body p-0">
          <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Progetto</th>
                <th>Area</th>
                <th>Descrizione</th>
                <th>Stato</th>
                <th>Utente</th>
                <th>Tecnico</th>
                <th>Data Eliminazione</th>
                <th>Azioni</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="ticket in props.tickets" :key="ticket.id">
                <td>{{ ticket.id }}</td>
                <td>{{ getProjectName(ticket.project_id) }}</td>
                <td>{{ getAreaName(ticket.area_id, props.areas) }}</td>
                <td>{{ ticket.description ? (ticket.description.length > 30 ? ticket.description.substring(0, 30) +
                  '...' :
                  ticket.description) : 'N/A' }}</td>
                <td>
                  <StatusBadge :status-id="ticket.status_id" :statuses="props.statuses" size="fs-6" />
                </td>
                <td>{{ getUserName(ticket.user_id, props.technicians) }}</td>
                <td>{{ getTechnicianName(ticket.assigned_to, props.technicians) || 'Non assegnato' }}</td>
                <td>{{ new Date(ticket.deleted_at).toLocaleDateString() }}</td>
                <td>
                  <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-success" @click="restore(ticket.id)" title="Ripristina">
                      <i class="fas fa-undo-alt"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" @click="forceDeleteTicket(ticket.id)"
                      title="Elimina definitivamente">
                      <i class="fas fa-trash-alt"></i>
                    </button>
                  </div>
                </td>
              </tr>
              <tr v-if="props.tickets.length === 0">
                <td colspan="9" class="text-center text-muted py-4">Nessun ticket nell'archivio</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
