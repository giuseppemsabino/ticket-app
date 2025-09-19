<script setup>
import { useForm, Head } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

// Props dal controller
const props = defineProps({
  user: Object,     // utente da modificare
  roles: Array,     // tutti i ruoli disponibili
  projects: Array,  // tutti i progetti disponibili
  userLog: Object,  // opzionale: chi sta modificando
})

// Inizializza form con dati dell’utente
const form = useForm({
  name: props.user.name || '',
  email: props.user.email || '',
  password: '',
  roles: props.user.roles ? props.user.roles.map(r => r.id) : [],
  projects: props.user.projects ? props.user.projects.map(p => p.id) : [],
})


// Submit del form
function submit() {
  form.put(route('users.update', props.user.id))
}
</script>

<template>

  <Head :title="`Modifica Utente: ${props.user.name}`">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </Head>

  <AuthenticatedLayout>
    <template #header>
      <h2 class="fs-4 fw-semibold">Modifica Utente</h2>
    </template>

    <div class="container mt-5">
      <div class="card shadow">
        <div class="card-body">

          <p v-if="props.userLog" class="text-muted mb-4">
            Modificato da: <strong>{{ props.userLog.name }}</strong>
          </p>

          <form @submit.prevent="submit">
            <!-- Nome -->
            <div class="mb-3">
              <label class="form-label">Nome*</label>
              <input type="text" class="form-control" v-model="form.name" required />
              <div v-if="form.errors.name" class="text-danger small">{{ form.errors.name }}</div>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label class="form-label">Email*</label>
              <input type="email" class="form-control" v-model="form.email" required />
              <div v-if="form.errors.email" class="text-danger small">{{ form.errors.email }}</div>
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label class="form-label">Password (lascia vuoto se non vuoi cambiarla)</label>
              <input type="password" class="form-control" v-model="form.password" />
              <div v-if="form.errors.password" class="text-danger small">{{ form.errors.password }}</div>
            </div>

            <!-- Ruoli (checkbox N:N) -->
            <div class="mb-3">
              <label class="form-label">Ruoli*</label>
              <div class="row row-cols-1 row-cols-md-2 g-2">
                <div class="col" v-for="role in props.roles" :key="role.id">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" :id="'role-' + role.id" :value="role.id"
                      v-model="form.roles" />
                    <label class="form-check-label" :for="'role-' + role.id">{{ role.name }}</label>
                  </div>
                </div>
              </div>
              <div v-if="form.errors.roles" class="text-danger small">{{ form.errors.roles }}</div>
            </div>

            <!-- Progetti (checkbox N:N) -->
            <div class="mb-3">
              <label class="form-label">Progetti*</label>
              <div class="row row-cols-1 row-cols-md-2 g-2">
                <div class="col" v-for="project in props.projects" :key="project.id">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" :id="'project-' + project.id" :value="project.id"
                      v-model="form.projects" />
                    <label class="form-check-label" :for="'project-' + project.id">{{ project.name }}</label>
                  </div>
                </div>
              </div>
              <div v-if="form.errors.projects" class="text-danger small">{{ form.errors.projects }}</div>
            </div>

            <!-- Pulsante salva -->
            <PrimaryButton :disabled="form.processing" type="submit">
              <i class="fas fa-save me-2"></i>Salva Modifiche
            </PrimaryButton>
          </form>
        </div>
      </div>
      <small class="text-danger p-3">
        * campi obbligatori
      </small>
    </div>
  </AuthenticatedLayout>
</template>
