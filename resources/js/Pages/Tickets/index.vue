<template>
    <div>
        <h2>Lista Ticket</h2>
        <ul>
            <li v-for="ticket in tickets" :key="ticket.id">
                {{ ticket.id }} - {{ ticket.description }} - {{ getAreaName(ticket.area_id) }} - {{ getUserName(ticket.user_id) }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        tickets: Array,
        areas: Array,
        user: Object
    },
    methods: {
        getAreaName(areaId) {
            const area = this.areas.find(a => a.id === areaId);
            return area ? area.name : 'N/A';
        },
        getUserName(userId) {
            return this.user && this.user.id === userId ? this.user.name : 'N/A';
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