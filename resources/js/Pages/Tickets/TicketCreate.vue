<script setup>
import { useForm, Head } from '@inertiajs/vue3'

//Layout
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

//Components
import PrimaryButton from '@/Components/PrimaryButton.vue'

// Props
const props = defineProps({
  areas: Array,
  statuses: Array,
  projects: Array,
  userLog: Object,
})

const form = useForm({
  description: '',
  area_id: '',
  status_id: '',
  project_id: '',
  u_images: null,
})

// form submit
function submit() {
  form.post(route('tickets.store'))
}
</script>

<template>

  <Head title="Crea Ticket">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </Head>

  <AuthenticatedLayout>
    <template #header class="header">
      <h2 class="fs-4 fw-semibold"><i class="fas fa-ticket me-2"></i>Nuovo Ticket</h2>
    </template>


    <div class="container mt-5">
      <div class="card shadow">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
          <h4 class="m-0 fw-bold "><i class="fas fa-plus-circle me-2"></i>Crea Nuovo Ticket</h4>
        </div>
        <div class="card-body">

          <!-- User Log -->
          <p class="text-muted mb-4">
            <i class="fas fa-user me-2"></i>Creato da: <strong>{{ props.userLog.name }}</strong>
          </p>

          <form @submit.prevent="submit">

            <div class="options d-flex gap-3 mb-4">

              <div class="row row-cols-2 g-3 w-100">
                <!-- Project -->
                <div class="col">
                  <label class="form-label"><i class="fas fa-project-diagram me-2"></i>Progetto*</label>
                  <div class="input-group">
                    <select v-model="form.project_id" class="form-select fs-6" required>
                      <option disabled value="">-- Seleziona Progetto --</option>
                      <option v-for="project in props.projects" :key="project.id" :value="project.id">
                        {{ project.name }}
                      </option>
                    </select>
                  </div>
                  <div v-if="form.errors.project_id" class="text-danger small">
                    {{ form.errors.project_id }}
                  </div>
                </div>

                <!-- Area -->
                <div class="col">
                  <label class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Area*</label>
                  <div class="input-group">

                    <select v-model="form.area_id" class="form-select" required>
                      <option disabled value="">-- Seleziona Area --</option>
                      <option v-for="area in props.areas" :key="area.id" :value="area.id">
                        {{ area.name }}
                      </option>
                    </select>
                  </div>
                  <div v-if="form.errors.area_id" class="text-danger small">
                    {{ form.errors.area_id }}
                  </div>
                </div>
              </div>
            </div>


            <!-- Description -->
            <div class="mb-3">
              <label class="form-label"><i class="fas fa-align-left me-2"></i>Descrizione*</label>
              <div class="input-group">

                <textarea v-model="form.description" class="form-control"
                  placeholder="Inserisci la descrizione del ticket" rows="4" required></textarea>
              </div>
              <div v-if="form.errors.description" class="text-danger small">
                {{ form.errors.description }}
              </div>
            </div>

            <!-- Image Upload-->
            <div class="mb-4">
              <label class="form-label" for="u_images"><i class="fas fa-image me-2"></i>Carica immagine</label>
              <div class="input-group">

                <input id="u_images" type="file" accept="image/*" @change="e => form.u_images = e.target.files[0]"
                  class="form-control" />
              </div>
              <div v-if="form.errors.u_images" class="text-danger small">
                {{ form.errors.u_images }}
              </div>
            </div>

            <!-- Disclaimer -->
            <div class="d-flex justify-content-between align-items-center mt-4">
              <small class="text-danger">
                <i class="fas fa-asterisk me-1"></i> campi obbligatori
              </small>

              <!-- Save button-->
              <PrimaryButton :disabled="form.processing" :type="'submit'" class="btn-lg">
                <i class="fas fa-ticket me-2"></i>Crea Ticket
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>

</template>

<style scoped>
.card {
  border-radius: 10px;
  transition: all 0.3s ease;
  border: none;
}

.card:hover {
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
}

.card-header {
  border-bottom: 2px solid rgba(0, 0, 0, 0.05);
  border-radius: 10px 10px 0 0 !important;
}

.form-control,
.form-select {
  border-radius: 5px;
  padding: 0.6rem;
  transition: all 0.2s;
}

.form-control:focus,
.form-select:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}

.input-group-text {
  border-top-left-radius: 5px;
  border-bottom-left-radius: 5px;
}

.form-label {
  font-weight: 500;
  margin-bottom: 0.5rem;
}
</style>
