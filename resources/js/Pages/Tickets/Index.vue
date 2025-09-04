<template>
  <div>
    <h2>Lista Ticket</h2>
    <ul>
      <li v-for="ticket in tickets" :key="ticket.id">
        {{ ticket.id }} - {{ ticket.description }} - {{ getAreaName(ticket.area_id) }} - {{ getUserName(ticket.user_id)
        }} - {{ getStatusName(ticket.status_id) }} - {{ getTechnicianName(ticket.assigned_to) }}
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    tickets: Array,
    areas: Array,
    userLog: Object,
    statuses: Array,
    technicians: Array
  },
  methods: {
    getAreaName(areaId) {
      const area = this.areas.find(area => area.id === areaId);
      return area ? area.name : 'N/A';
    },
    getUserName(userId) {
      return this.userLog && this.userLog.id === userId ? this.userLog.name : 'N/A';
    },
    getStatusName(statusId) {
      const status = this.statuses.find(status => status.id === statusId);
      return status ? status.name : 'N/A';
    },
    getTechnicianName(technicianId) {
      const technician = this.technicians.find(tech => tech.id === technicianId);
      return technician ? technician.name : 'N/A';
    }

  }
}
</script>

<style scoped>
div {
  font-size: 1.2rem;
  color: #333;
}
</style>