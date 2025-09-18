<script setup>
import { usePage, Link } from '@inertiajs/vue3'
import { computed } from 'vue'
import StatusBadge from '../Components/StatusBadge.vue'

const props = defineProps({
  tickets: Array,
  statuses: Array,
  areas: Array,
})

const page = usePage()

const statuses = computed(() => props.statuses ?? page.props?.statuses ?? [])
const areas = computed(() => props.areas ?? page.props?.areas ?? [])

function getAreaName(areaId) {
  const area = areas.value.find((area) => area.id === areaId);
  return area ? area.name : "N/A";
}
</script>


<template>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>descrizione</th>
        <th>Area</th>
        <th>Stato</th>
        <th>Utente</th>
        <th>Data</th>
        <th>Azioni</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="ticket in tickets" :key="ticket.id">
        <td>{{ ticket.id }}</td>
        <td>{{ ticket.description }}</td>
        <td>{{ getAreaName(ticket.area_id) }}</td>
        <td>
          <StatusBadge :status-id="ticket.status_id" :statuses="statuses" size="fs-6" />
        </td>
        <td>{{ new Date(ticket.created_at).toLocaleDateString() }}</td>
        <td>
          <Link :href="`/tickets/${ticket.id}/edit`">
          <button class="btn btn-sm btn-primary me-1">Dettagli</button>
          </Link>
        </td>
      </tr>
    </tbody>
  </table>
</template>