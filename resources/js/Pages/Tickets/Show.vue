<script setup>
import { Head, Link } from '@inertiajs/vue3';
import StatusBadge from '@/Components/StatusBadge.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
  ticket: Object,
  areas: Array,
  projects: Array,
  userLog: Object,
  statuses: Array,
  technicians: Array,
  comments: Array,
});

const getProjectName = (projectId) => {
  const project = props.projects.find((project) => project.id === projectId);
  return project ? project.name : "N/A";
};

const getAreaName = (areaId) => {
  const area = props.areas.find((area) => area.id === areaId);
  return area ? area.name : "N/A";
};

const getUserName = (userId) => {
  if (userId === props.userLog.id) return props.userLog.name;
  const commentUser = props.comments.find((c) => c.user.id === userId);
  return commentUser ? commentUser.user.name : "N/A";
};

const getStatusName = (statusId) => {
  const status = props.statuses.find((status) => status.id === statusId);
  return status ? status.name : "N/A";
};

const getTechnicianName = (technicianId) => {
  const technician = props.technicians.find((tech) => tech.id === technicianId);
  return technician ? technician.name : "N/A";
};
</script>

<template>

  <Head :title="`Ticket #${ticket.id}`" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Ticket #{{ ticket.id }}
      </h2>
    </template>
    <div class="ticket-show card p-4 shadow">

      <div class="card-header d-flex justify-content-between align-items-center mb-4" style="border-bottom: dashed;">
        <h1>Ticket #{{ ticket.id }}</h1>
        <!-- status -->
        <StatusBadge :status-id="ticket.status_id" :statuses="statuses" :size="'fs-5'" />
      </div>

      <!-- date -->
      <div class="dates">
        <p class="text-muted">
          Creato il: {{ new Date(ticket.created_at).toLocaleString() }}
        </p>
        <hr>
      </div>

      <!-- Details -->
      <div v-if="ticket">

        <div class="d-flex justify-content-between">
          <p><strong>Progetto:</strong> {{ getProjectName(ticket.project_id) }}</p>
          <p><strong>Area:</strong> {{ getAreaName(ticket.area_id) }}</p>
        </div>
        <p class="mt-4"><strong>Descrizione:</strong> </p>
        <p class="mb-4 fs-4">
          {{ ticket.description }}
        </p>
        <div class="image">
          <img :src="ticket.u_images" alt="">
        </div>
        <p><strong>Creatore:</strong> {{ getUserName(ticket.user_id) }}</p>
        <p>
          <strong>Tecnico:</strong>
          {{ getTechnicianName(ticket.assigned_to) }}
        </p>


        <!-- Interventi -->
        <div v-if="comments && comments.length" class=" comments mt-4">
          <h2 class="text-danger fw-bold">Interventi</h2>
          <div>
            <div v-for="comment in comments" :key="comment.id" class="comment p-2 mb-2 border rounded">
              <p>
                <strong>{{ comment.user.name }}:</strong>
                {{ comment.content }}
              </p>
              <small class="text-muted">{{
                new Date(comment.created_at).toLocaleString()
              }}</small>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <p>Caricamento ticket...</p>
      </div>
    </div>
    <div class="text-center mt-4">
      <PrimaryButton>
        <Link href="/dashboard" class="btn-link text-decoration-none ">
        Torna alla Dashboard
        </Link>
      </PrimaryButton>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.ticket-show {
  max-width: 600px;
  margin: 2rem auto;
  padding: 2rem;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.ticket-show h1 {
  margin-bottom: 1.5rem;
}

.ticket-show p {
  margin: 0.5rem 0;
}

.comments h2 {
  margin-bottom: 1rem;
}

.comment {
  background: #f9f9f9;
}
</style>