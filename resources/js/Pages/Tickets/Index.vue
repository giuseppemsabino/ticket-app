<script setup>
import { getAreaName, getUserName, getTechnicianName, getStatusName, deleteTicket } from '@/lib/utils';
import { router } from '@inertiajs/vue3'; // Import router for delete functionality

const props = defineProps({
  tickets: Array,
  areas: Array,
  userLog: Object,
  statuses: Array,
  technicians: Array,
  userName: Array,
});

const getArea = (areaId) => getAreaName(areaId, props.areas);
const getUser = (userId) => getUserName(userId, props.userName);
const getStatus = (statusId) => getStatusName(statusId, props.statuses);
const getTechnician = (techId) => getTechnicianName(techId, props.technicians);
const deleteTicketHandler = (ticketId) => deleteTicket(ticketId, router, route);

console.log(props.userName);
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
        <tr v-for="ticket in tickets" :key="ticket.id">
          <td>{{ ticket.id }}</td>
          <td>{{ ticket.description }}</td>
          <td>{{ getArea(ticket.area_id) }}</td>
          <td>{{ getUser(ticket.user_id) }}</td>
          <td>{{ getStatus(ticket.status_id) }}</td>
          <td>{{ getTechnician(ticket.assigned_to) }}</td>
          <td>
            <button @click="deleteTicketHandler(ticket.id)">
              Elimina
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
