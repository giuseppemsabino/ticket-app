<script setup>
const props = defineProps({
  tickets: Array,
  areas: Array,
  userLog: Object,
  statuses: Array,
  technicians: Array,
});
</script>


<template>
  <div>
    <h2>Lista Ticket</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Descrizione</th>
          <th>Area</th>
          <th>Utente</th>
          <th>Status</th>
          <th>Tecnico</th>
          <th>Azioni</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="ticket in props.tickets" :key="ticket.id">
          <td>{{ ticket.id }}</td>
          <td>{{ ticket.description }}</td>
          <td>{{ (ticket.area_id) }}</td>
          <td>{{ (ticket.user_id) }}</td>
          <td>{{ (ticket.status_id) }}</td>

          <td>
            <button @click="deleteTicket(ticket.id)">
              Elimina
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>