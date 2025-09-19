<script setup>
import { Head, Link } from '@inertiajs/vue3';
//Layout
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

//Components
import StatusBadge from '@/Components/StatusBadge.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { getAreaName, getUserName, getTechnicianName } from '@/lib/utils';

//Props
const props = defineProps({
  ticket: Object,
  areas: Array,
  projects: Array,
  userLog: Object,
  statuses: Array,
  technicians: Array,
  comments: Array,
  userName: Array,
});

const getProjectName = (projectId) => {
  const project = props.projects.find((project) => project.id === projectId);
  return project ? project.name : "N/A";
};

const getArea = (areaId) => getAreaName(areaId, props.areas);
const getUser = (userId) => getUserName(userId, props.userName);
const getTechnician = (techId) => getTechnicianName(techId, props.technicians);
</script>

<template>

  <Head :title="`Ticket #${ticket.id}`">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </Head>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="fs-4 fw-semibold">
        <i class="fas fa-ticket-alt me-2"></i>Ticket #{{ ticket.id }}
      </h2>
    </template>

    <div class="container my-5">

      <!-- Ticket Show Card -->
      <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center py-3">
          <h3 class="mb-0"><i class="fas fa-ticket-alt me-2"></i>Ticket #{{ ticket.id }}</h3>
          <!-- status -->
          <StatusBadge :status-id="ticket.status_id" :statuses="statuses" :size="'fs-5'" />
        </div>

        <div class="card-body p-4">
          <!-- Date -->
          <div class="mb-3">
            <p class="text-muted">
              <i class="far fa-calendar-alt me-2"></i>Creato il:
              {{ new Date(ticket.created_at).toLocaleString() }}
            </p>
            <hr>
          </div>

          <!-- Details -->
          <div v-if="ticket">
            <div class="row mb-4">
              <div class="col-md-6">
                <p class="mb-2">
                  <i class="fas fa-project-diagram me-2 text-primary"></i><strong>Progetto:</strong>
                  {{ getProjectName(ticket.project_id) }}
                </p>
              </div>
              <div class="col-md-6">
                <p class="mb-2">
                  <i class="fas fa-layer-group me-2 text-primary"></i><strong>Area:</strong>
                  {{ getAreaName(ticket.area_id) }}
                </p>
              </div>
            </div>
            <!-- Description -->
            <div class="mb-4">
              <h4 class="mb-2"><i class="fas fa-align-left me-2 text-primary"></i><strong>Descrizione:</strong></h4>
              <div class="p-3 border-start border-primary border-3">
                <p class="mb-0 fs-5">{{ ticket.description }}</p>
              </div>
            </div>
            <!-- Image -->
            <div v-if="props.ticket.u_images" class="mb-4">
              <h5 class="mb-2">
                <i class="fas fa-image me-2 text-primary"></i>Immagine allegata:
              </h5>
              <div class="text-center p-3 border rounded bg-light">
                <a :href="`/storage/${ticket.u_images}`" target="_blank">
                  <img :src="`/storage/${ticket.u_images}`" alt="Ticket image" class="img-fluid rounded w-50">
                </a>
              </div>
            </div>
            <!-- Creator and Technician -->
            <div class="row mb-3">
              <div class="col-md-6">
                <p class="mb-2">
                  <i class="fas fa-user me-2 text-primary"></i><strong>Creatore:</strong>
                  {{ getUserName(ticket.user_id) }}
                </p>
              </div>
              <div class="col-md-6">
                <p class="mb-2">
                  <i class="fas fa-user-cog me-2 text-primary"></i><strong>Tecnico:</strong>
                  {{ getTechnicianName(ticket.assigned_to) || 'Non assegnato' }}
                </p>
              </div>
            </div>

            <!-- Comments -->
            <div v-if="comments && comments.length" class="mt-5">
              <h4 class="mb-3 d-flex align-items-center">
                <i class="fas fa-comments me-2 text-danger"></i>
                <span class="text-danger fw-bold">Interventi</span>
              </h4>
              <div class="ps-4">
                <div v-for="comment in comments" :key="comment.id" class="comment p-3 mb-3 border rounded bg-light">
                  <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-user-circle me-2 text-secondary"></i>
                    <strong>{{ comment.user.name }}:</strong>
                  </div>
                  <p class="mb-2 ps-4">{{ comment.content }}</p>
                  <!-- Comment Date/Time -->
                  <small class="text-muted d-block text-end">
                    <i class="far fa-clock me-1"></i>
                    {{ new Date(comment.created_at).toLocaleString() }}
                  </small>
                </div>
              </div>
            </div>
          </div>
          <!-- Loading -->
          <div v-else class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Caricamento ticket...</p>
          </div>
        </div>
      </div>
      <!-- Back to Dashboard Button -->
      <div class="text-center mt-4">
        <PrimaryButton>
          <Link href="/dashboard" class="btn-link text-decoration-none">
          <i class="fas fa-home me-2"></i>Torna alla Dashboard
          </Link>
        </PrimaryButton>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.card {
  max-width: 800px;
  margin: 0 auto;
}

.comment {
  transition: all 0.2s ease;
}

.comment:hover {
  background: #f0f0f0;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.border-start.border-primary {
  background-color: rgba(13, 110, 253, 0.03);
}

img.img-fluid {
  max-height: 300px;
  object-fit: contain;
}
</style>