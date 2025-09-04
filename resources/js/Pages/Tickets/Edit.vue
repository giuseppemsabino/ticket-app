<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
  ticket: Object,
  statuses: Array,
  areas: Array,
  projects: Array,
  userLog: Object, // tecnico loggato
  technicians: Array // lista tecnici
})

// Form principale per update
const form = useForm({
  description: props.ticket.description,
  area_id: props.ticket.area_id,
  project_id: props.ticket.project_id,
  status_id: props.ticket.status_id,
  assigned_to: props.ticket.assigned_to || '', // selection dei tecnici
})

// Submit verso update
function submit() {
  form.put(route('tickets.update', props.ticket.id))
}
</script>

<template>
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-body">
        <h1 class="h4 mb-4">Modifica Ticket #{{ props.ticket.id }}</h1>

        <form @submit.prevent="submit">

          <!-- Descrizione -->
          <div class="mb-3">
            <label class="form-label">Descrizione</label>
            <textarea v-model="form.description" class="form-control"></textarea>
            <div v-if="form.errors.description" class="text-danger small">
              {{ form.errors.description }}
            </div>
          </div>

          <!-- Area -->
          <div class="mb-3">
            <label class="form-label">Area</label>
            <select v-model="form.area_id" class="form-select">
              <option disabled value="">-- Seleziona Area --</option>
              <option v-for="area in props.areas" :key="area.id" :value="area.id">
                {{ area.name }}
              </option>
            </select>
            <div v-if="form.errors.area_id" class="text-danger small">{{ form.errors.area_id }}</div>
          </div>

          <!-- Progetto -->
          <div class="mb-3">
            <label class="form-label">Progetto</label>
            <select v-model="form.project_id" class="form-select">
              <option disabled value="">-- Seleziona Progetto --</option>
              <option v-for="project in props.projects" :key="project.id" :value="project.id">
                {{ project.name }}
              </option>
            </select>
            <div v-if="form.errors.project_id" class="text-danger small">{{ form.errors.project_id }}</div>
          </div>

          <!-- Stato -->
          <div class="mb-3">
            <label class="form-label">Stato</label>
            <select v-model="form.status_id" class="form-select">
              <option disabled value="">-- Seleziona Stato --</option>
              <option v-for="status in props.statuses" :key="status.id" :value="status.id">
                {{ status.name }}
              </option>
            </select>
            <div v-if="form.errors.status_id" class="text-danger small">{{ form.errors.status_id }}</div>
          </div>

          <!-- Tecnico assegnato -->
          <div class="mb-3">
            <label class="form-label">Assegnato a</label>
            <select v-model="form.assigned_to" class="form-select">
              <option disabled value="">-- Seleziona Tecnico --</option>
              <option v-for="tech in props.technicians" :key="tech.id" :value="tech.id">
                {{ tech.name }}
              </option>
            </select>
            <div v-if="form.errors.assigned_to" class="text-danger small">{{ form.errors.assigned_to }}</div>
          </div>

          <button type="submit" class="btn btn-success" :disabled="form.processing">
            Salva Modifiche
          </button>
        </form>
      </div>
    </div>
  </div>
</template>
