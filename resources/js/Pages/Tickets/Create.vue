<script setup>
import { useForm, Head } from '@inertiajs/vue3'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

import PrimaryButton from '@/Components/PrimaryButton.vue'

// Props che ricevi dal controller
const props = defineProps({
  areas: Array,
  statuses: Array,
  projects: Array,
  userLog: Object, // opzionale: solo per mostrare chi crea il ticket
})

const form = useForm({
  description: '',
  area_id: '',
  status_id: '',
  project_id: '',
  u_images: null, // immagine caricata dall’utente
})

// Submit del form
function submit() {
  form.post(route('tickets.store'))
}
</script>

<template>

  <Head title="Crea Ticket" />

  <AuthenticatedLayout>
    <template #header class="header">
      <h2 class="fs-4 fw-semibold">Nuovo Ticket</h2>
    </template>


    <div class="container mt-5">
      <div class="card shadow">
        <div class="card-body">

          <!-- Mostra utente loggato -->
          <p class="text-muted mb-4">
            Creato da: <strong>{{ props.userLog.name }}</strong>
          </p>

          <form @submit.prevent="submit">

            <div class="options d-flex gap-3 mb-4">

              <div class="row row-cols-1 row-cols-md-2 g-3">
                <!-- Progetto -->
                <div class="col">
                  <label class="form-label">Progetto</label>
                  <select v-model="form.project_id" class="form-select">
                    <option disabled value="">-- Seleziona Progetto --</option>
                    <option v-for="project in props.projects" :key="project.id" :value="project.id">
                      {{ project.name }}
                    </option>
                  </select>
                  <div v-if="form.errors.project_id" class="text-danger small">
                    {{ form.errors.project_id }}
                  </div>
                </div>

                <!-- Area -->
                <div class="col">
                  <label class="form-label">Area</label>
                  <select v-model="form.area_id" class="form-select">
                    <option disabled value="">-- Seleziona Area --</option>
                    <option v-for="area in props.areas" :key="area.id" :value="area.id">
                      {{ area.name }}
                    </option>
                  </select>
                  <div v-if="form.errors.area_id" class="text-danger small">
                    {{ form.errors.area_id }}
                  </div>
                </div>
              </div>
            </div>


            <!-- Descrizione -->
            <div class="mb-3">
              <label class="form-label">Descrizione</label>
              <textarea v-model="form.description" class="form-control"
                placeholder="Inserisci la descrizione del ticket"></textarea>
              <div v-if="form.errors.description" class="text-danger small">
                {{ form.errors.description }}
              </div>
            </div>

            <!-- Upload immagine utente -->
            <div>
              <label class="mb-2" for="u_images">Carica immagine</label>
              <input id="u_images" type="file" accept="image/*" @change="e => form.u_images = e.target.files[0]"
                class="form-control  mb-2" />
              <div v-if="form.errors.u_images" class="text-red-500 text-sm">{{ form.errors.u_images }}</div>
            </div>



            <!-- Pulsante salva -->
            <PrimaryButton :disabled="form.processing" :type="'submit'">
              Crea Ticket
            </PrimaryButton>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

</template>
