<script setup>
import { router } from "@inertiajs/vue3";

const props = defineProps({
  tickets: Array,
  areas: Array,
  userLog: Object,
  statuses: Array,
  technicians: Array,
  userName: Array,
});

const getAreaName = (areaId) => {
  const area = props.areas.find((area) => area.id === areaId);
  return area ? area.name : "N/A";
};

const getUserName = (userId) => {
  const user = props.userName.find(user => user.id === userId);
  return user ? user.name : "N/A";
};

const getStatusName = (statusId) => {
  const status = props.statuses.find(
    (status) => status.id === statusId
  );
  return status ? status.name : "N/A";
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
          <td>{{ getAreaName(ticket.area_id) }}</td>
          <td>{{ getUserName(ticket.user_id) }}</td>
          <td>{{ getStatusName(ticket.status_id) }}</td>
          <td>{{ getTechnicianName(ticket.assigned_to) }}</td>
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
