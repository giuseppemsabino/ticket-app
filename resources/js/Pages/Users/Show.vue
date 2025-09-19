<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

// Props dal controller
const props = defineProps({
  user: {
    type: Object,
    required: true
  }
})
</script>

<template>

  <Head :title="`Dettagli Utente: ${props.user.name}`">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </Head>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="fs-4 fw-semibold">Dettagli Utente</h2>
    </template>

    <div class="container mt-5">
      <div class="d-flex justify-content-end mb-4">
        <Link :href="route('users.edit', props.user.id)" class="btn btn-outline-primary me-2" title="Modifica utente">
        <i class="fas fa-pencil-alt me-2"></i>Modifica
        </Link>
        <Link :href="route('users.index')" class="btn btn-outline-secondary" title="Torna alla lista utenti">
        <i class="fas fa-arrow-left me-2"></i>Torna alla lista
        </Link>
      </div>

      <div class="card shadow">
        <div class="card-body">
          <div v-if="props.user">
            <div class="row mb-4">
              <div class="col-12 col-md-6">
                <h4 class="mb-3 fw-semibold"><i class="fas fa-id-card me-2"></i>Informazioni Personali</h4>
                <div class="border-start ps-3 mb-4">
                  <p class="mb-2"><strong>ID:</strong> {{ props.user.id }}</p>
                  <p class="mb-2"><strong>Nome:</strong> {{ props.user.name }}</p>
                  <p class="mb-0"><strong>Email:</strong> {{ props.user.email }}</p>
                </div>

                <h4 class="mb-3 fw-semibold"><i class="fas fa-user-tag me-2"></i>Ruoli</h4>
                <div class="border-start ps-3">
                  <div v-if="props.user.roles && props.user.roles.length">
                    <div class="mb-1" v-for="role in props.user.roles" :key="role.id">
                      <span class="badge bg-info">{{ role.name }}</span>
                    </div>
                  </div>
                  <p v-else class="mb-0 text-muted">Nessun ruolo associato.</p>
                </div>
              </div>

              <div class="col-12 col-md-6 mt-4 mt-md-0">
                <h4 class="mb-3 fw-semibold"><i class="fas fa-project-diagram me-2"></i>Progetti Associati</h4>
                <div class="border-start ps-3">
                  <ul class="list-group list-group-flush" v-if="props.user.projects && props.user.projects.length">
                    <li class="list-group-item bg-transparent px-0" v-for="project in props.user.projects"
                      :key="project.id">
                      <i class="fas fa-folder me-2 text-primary"></i>{{ project.name }}
                    </li>
                  </ul>
                  <p v-else class="mb-0 text-muted">Nessun progetto associato.</p>
                </div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-5">
            <div class="spinner-border text-primary mb-3" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
            <p>Caricamento dati utente...</p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>