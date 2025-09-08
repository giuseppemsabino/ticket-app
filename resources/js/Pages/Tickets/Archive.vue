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

<script>
import { router } from "@inertiajs/vue3";

export default {
    props: {
        tickets: Array,
        areas: Array,
        userLog: Object,
        statuses: Array,
        technicians: Array,
    },
    methods: {
        getAreaName(areaId) {
            const area = this.areas.find((area) => area.id === areaId);
            return area ? area.name : "N/A";
        },
        getUserName(userId) {
            return this.userLog && this.userLog.id === userId
                ? this.userLog.name
                : "N/A";
        },
        getStatusName(statusId) {
            const status = this.statuses.find(
                (status) => status.id === statusId
            );
            return status ? status.name : "N/A";
        },
        getTechnicianName(technicianId) {
            const technician = this.technicians.find(
                (tech) => tech.id === technicianId
            );
            return technician ? technician.name : "N/A";
        },
        deleteTicket(ticketId) {
            if (confirm("Sei sicuro di voler eliminare questo ticket?")) {
                router.delete(route("tickets.destroy", ticketId));
            }
        },
    },
};
</script>
