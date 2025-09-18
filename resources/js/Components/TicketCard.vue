<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import StatusBadge from '../Components/StatusBadge.vue'
import { getAreaName } from '@/lib/utils'

const props = defineProps({
  ticket: Object,
  statuses: Array,
  areas: Array,
  userName: Array,
})

const page = usePage()

const statuses = computed(() => props.statuses ?? page.props?.statuses ?? [])
const areas = computed(() => props.areas ?? page.props?.areas ?? [])

const getArea = (areaId) => getAreaName(areaId, areas.value);
</script>

<template>
  <Link :href="`/tickets/${ticket.id}/edit`" class="text-decoration-none text-dark">

  <div class="card h-100 shadow-sm" style="width: 20rem;">
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
      <p class="card-text mb-1"><strong>Area:</strong> {{ getArea(ticket.area_id) }}</p>
      <div class="mt-auto">
        <p class="card-text"><small class="text-muted">Creato il: {{ new
          Date(ticket.created_at).toLocaleString() }}</small></p>
      </div>
    </div>

  </div>

  </Link>
</template>