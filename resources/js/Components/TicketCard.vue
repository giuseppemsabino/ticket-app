<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import StatusBadge from '../Components/StatusBadge.vue'


const props = defineProps({
  ticket: Object,
  statuses: Array,
  areas: Array,
  projects: Array
})

const page = usePage()

const statuses = computed(() => props.statuses ?? page.props?.statuses ?? [])
const areas = computed(() => props.areas ?? page.props?.areas ?? [])
const projects = computed(() => props.projects ?? page.props?.projects ?? [])

function getAreaName(areaId) {
  const area = areas.value.find((area) => area.id === areaId);
  return area ? area.name : "N/A";
}



function getProjectName(projectId) {
  const project = projects.value.find((project) => project.id === projectId);
  return project ? project.name : "N/A";
}
</script>

<template>
  <Link :href="`/tickets/${ticket.id}/edit`" class="text-decoration-none text-dark">
  <div class="card h-100 shadow-sm ticket-card" style="width: 20rem;">
    <div class="card-header position-relative">
      <div class="d-flex justify-content-between align-items-center">
        <span class="fw-semibold">
          <i class="fas fa-ticket-alt me-1"></i> Ticket #{{ ticket.id }}
        </span>
        <StatusBadge :status-id="ticket.status_id" :statuses="statuses" size="fs-6" />
      </div>
    </div>

    <div class="card-body d-flex flex-column">
      <div class="description-container">
        <h5 class="card-title mb-3">{{ ticket.description && ticket.description.length > 60
          ? ticket.description.substring(0, 60) + '...'
          : ticket.description }}</h5>
      </div>

      <div class="card-details">
        <p class="card-text mb-2">
          <i class="fas fa-project-diagram  me-2"></i>
          <strong>Progetto:</strong> {{ getProjectName(ticket.project_id) }}
        </p>
        <p class="card-text mb-2">
          <i class="fas fa-layer-group me-2"></i>
          <strong>Area:</strong> {{ getAreaName(ticket.area_id) }}
        </p>

      </div>

      <div class="mt-auto pt-2 border-top">
        <p class="card-text d-flex align-items-center">
          <i class="far fa-calendar-alt text-muted me-2"></i>
          <small class="text-muted">{{ new Date(ticket.created_at).toLocaleString() }}</small>
        </p>
      </div>
    </div>

    <div class="hover-overlay"></div>
  </div>
  </Link>
</template>

<style scoped>
.description-container {
  min-height: 4rem;
}

.card-details {
  font-size: 0.9rem;
}

.hover-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: transparent;
  transition: background 0.3s;
}

.ticket-card:hover .hover-overlay {
  background: #00285B;
}
</style>