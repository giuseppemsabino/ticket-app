<script setup>
import { useForm } from '@inertiajs/vue3'

// Props che ricevi dal controller
const props = defineProps({
  areas: Array,
  statuses: Array,
  projects: Array,
  userLog: Object,   // opzionale: per mostrare chi sta creando il ticket
})

const form = useForm({
  description: '',
  area_id: '',
  status_id: '',
  project_id: '',
})

// Submit del form
function submit() {
  form.post(route('tickets.store'))
}
</script>

<template>
  <div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">Crea Nuovo Ticket</h1>

    <!-- Mostra utente loggato -->
    <p class="text-gray-600 mb-4">
      Creato da: <strong>{{ props.userLog.name }}</strong>
    </p>

    <form @submit.prevent="submit" class="space-y-4">

      <!-- Descrizione -->
      <div>
        <label class="block font-medium">Descrizione</label>
        <textarea
          v-model="form.description"
          class="border rounded p-2 w-full"
          placeholder="Inserisci la descrizione del ticket"
        ></textarea>
        <div v-if="form.errors.description" class="text-red-500 text-sm">{{ form.errors.description }}</div>
      </div>

      <!-- Area -->
      <div>
        <label class="block font-medium">Area</label>
        <select v-model="form.area_id" class="border rounded p-2 w-full">
          <option disabled value="">-- Seleziona Area --</option>
          <option v-for="area in props.areas" :key="area.id" :value="area.id">
            {{ area.name }}
          </option>
        </select>
        <div v-if="form.errors.area_id" class="text-red-500 text-sm">{{ form.errors.area_id }}</div>
      </div>

      <!-- Stato -->
      <div>
        <label class="block font-medium">Stato</label>
        <select v-model="form.status_id" class="border rounded p-2 w-full">
          <option disabled value="">-- Seleziona Stato --</option>
          <option v-for="status in props.statuses" :key="status.id" :value="status.id">
            {{ status.name }}
          </option>
        </select>
        <div v-if="form.errors.status_id" class="text-red-500 text-sm">{{ form.errors.status_id }}</div>
      </div>

      <!-- Progetto -->
      <div>
        <label class="block font-medium">Progetto</label>
        <select v-model="form.project_id" class="border rounded p-2 w-full">
          <option disabled value="">-- Seleziona Progetto --</option>
          <option v-for="project in props.projects" :key="project.id" :value="project.id">
            {{ project.name }}
          </option>
        </select>
        <div v-if="form.errors.project_id" class="text-red-500 text-sm">{{ form.errors.project_id }}</div>
      </div>

      <!-- Pulsante salva -->
      <button
        type="submit"
        class="bg-blue-600 text-white px-4 py-2 rounded"
        :disabled="form.processing"
      >
        Salva Ticket
      </button>
    </form>
  </div>
</template>
