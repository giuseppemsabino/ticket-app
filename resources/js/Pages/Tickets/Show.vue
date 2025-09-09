<script>
export default {
    props: {
        ticket: Object,
        areas: Array,
        userLog: Object,
        statuses: Array,
        technicians: Array,
        comments: Array, // ✅ aggiunto per i commenti
    },
    methods: {
        getAreaName(areaId) {
            const area = this.areas.find((area) => area.id === areaId);
            return area ? area.name : "N/A";
        },
        getUserName(userId) {
            if (userId === this.userLog.id) return this.userLog.name;
            const commentUser = this.comments.find(c => c.user.id === userId);
            return commentUser ? commentUser.user.name : "N/A";
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
    },
};
</script>

<template>
    <div class="ticket-show">
        <h1>Dettaglio Ticket</h1>
        <div v-if="ticket">
            <p><strong>ID:</strong> {{ ticket.id }}</p>
            <p><strong>Descrizione:</strong> {{ ticket.description }}</p>
            <p><strong>Area:</strong> {{ getAreaName(ticket.area_id) }}</p>
            <p><strong>Creatore:</strong> {{ getUserName(ticket.user_id) }}</p>
            <p><strong>Tecnico:</strong> {{ getTechnicianName(ticket.assigned_to) }}</p>
            <p><strong>Status:</strong> {{ getStatusName(ticket.status_id) }}</p>
            <p><strong>Creato il:</strong> {{ ticket.created_at }}</p>
            <p><strong>Aggiornato il:</strong> {{ ticket.updated_at }}</p>

            <!-- Lista commenti -->
            <div class="comments mt-4">
                <h2>Commenti</h2>
                <div v-if="comments && comments.length">
                    <div
                        v-for="comment in comments"
                        :key="comment.id"
                        class="comment p-2 mb-2 border rounded"
                    >
                        <p><strong>{{ comment.user.name }}:</strong> {{ comment.content }}</p>
                        <small class="text-muted">{{ comment.created_at }}</small>
                    </div>
                </div>
                <div v-else>
                    <p>Nessun commento ancora.</p>
                </div>
            </div>
        </div>
        <div v-else>
            <p>Caricamento ticket...</p>
        </div>
    </div>
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
