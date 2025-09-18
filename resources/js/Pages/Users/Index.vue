<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

// Props dal controller
const props = defineProps({
  users: Array, // lista utenti
  auth: Object, // utente loggato
})

// Funzione delete
function destroy(userId) {
  if (confirm('Sei sicuro di voler eliminare questo utente?')) {
    router.delete(route('users.destroy', userId))
  }
}
</script>

<template>

  <Head title="Utenti" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="fs-4 fw-semibold">Gestione Utenti</h2>
    </template>

    <div class="container mt-5">
      <div class="mb-3">
        <Link href="/users/create">
        <PrimaryButton>Crea Nuovo Utente</PrimaryButton>
        </Link>
      </div>

      <div class="card shadow">
        <div class="card-body p-0">
          <table class="table table-striped mb-0">
            <thead class="table-dark">
              <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ruoli</th>
                <th>Progetti</th>
                <th>Azioni</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="user in props.users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>
                  <div v-if="user.roles.length">
                    {{user.roles.map(role => role.name).join(', ')}}
                  </div>
                  <div v-else>-</div>
                </td>
                <td>
                  <div v-if="user.projects.length">
                    {{user.projects.map(project => project.name).join(', ')}}
                  </div>
                  <div v-else>-</div>
                </td>
                <td>
                  <Link :href="route('users.edit', user.id)" class="btn btn-sm btn-warning me-2">Modifica</Link>
                  <button class="btn btn-sm btn-danger" @click="destroy(user.id)">Elimina</button>
                </td>
              </tr>
              <tr v-if="props.users.length === 0">
                <td colspan="6" class="text-center text-muted">Nessun utente trovato</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
