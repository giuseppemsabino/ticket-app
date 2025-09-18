<template>
    <div class="user-show">
        <h1>Dettagli Utente</h1>
        <div v-if="user">
            <p><strong>ID:</strong> {{ user.id }}</p>
            <p><strong>Nome:</strong> {{ user.name }}</p>
            <p><strong>Email:</strong> {{ user.email }}</p>
            <p>
                <strong>Ruoli:</strong>
                <span v-if="user.roles && user.roles.length">
                    <span v-for="(role, idx) in user.roles" :key="role.id">
                        {{ role.name }}<span v-if="idx < user.roles.length - 1">, </span>
                    </span>
                </span>
                <span v-else>Nessun ruolo associato.</span>
            </p>
            <div>
                <strong>Progetti Relazionati:</strong>
                <ul v-if="user.projects && user.projects.length">
                    <li v-for="project in user.projects" :key="project.id">
                        {{ project.name }}
                    </li>
                </ul>
                <span v-else>Nessun progetto associato.</span>
            </div>
        </div>
        <div v-else>
            <p>Caricamento dati utente...</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UserShow',
    props: {
        user: {
            type: Object,
            required: true
        }
    }
}
</script>

<style scoped>
.user-show {
    max-width: 500px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}
</style>