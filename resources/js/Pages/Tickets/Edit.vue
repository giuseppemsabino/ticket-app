<script setup>
import { useForm, Head } from "@inertiajs/vue3";

//Layout
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

//Components
import PrimaryButton from "@/Components/PrimaryButton.vue";

//Props
const props = defineProps({
  ticket: Object,
  statuses: Array,
  areas: Array,
  projects: Array,
  userLog: Object, // tecnico loggato
  technicians: Array, // lista tecnici
  userName: Array,
});

//comments list
const comments = props.ticket.comments || [];

// update form
const form = useForm({
  description: props.ticket.description,
  area_id: props.ticket.area_id,
  project_id: props.ticket.project_id,
  status_id: props.ticket.status_id,
  assigned_to: props.ticket.assigned_to || "", // selection dei tecnici
});

// update form submit
function submit() {
  form.put(route("tickets.update", props.ticket.id));
}

// comment form
const commentForm = useForm({
  content: "", // campo del commento
});

function submitComment() {
  commentForm.post(route("comments.store", props.ticket.id), {
    onSuccess: () => commentForm.reset(),
  });
}

function deleteComment(commentId) {
  if (confirm("Sei sicuro di voler eliminare questo commento?")) {
    commentForm.delete(route("comments.destroy", commentId));
  }
}

const getUser = (userId) => getUserName(userId, props.userName);
</script>

<template>

  <Head :title="`Modifica Ticket #${props.ticket.id}`">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </Head>

  <AuthenticatedLayout>


    <template #header>
      <h2 class="fs-4 fw-semibold">
        <i class="fas fa-edit me-2"></i>Modifica Ticket #{{ props.ticket.id }}
      </h2>
    </template>

    <div class="container mt-5">


      <!-- Ticket Form -->
      <div class="card shadow mb-4">
        <div class="card-header bg-light py-3">
          <h4 class="mb-0">
            <i class="fas fa-clipboard-list me-2"></i>Dettagli Ticket #{{ props.ticket.id }}
          </h4>
        </div>
        <div class="card-body">
          <div class="mb-4">
            <h5 class="mb-2">
              <i class="fas fa-align-left me-2 text-primary"></i>Descrizione:
            </h5>
            <div class="p-3 border-start border-primary border-3 bg-light rounded">
              <p class="fs-5 mb-0">{{ props.ticket.description }}</p>
            </div>
          </div>

          <!-- Immagine del ticket se presente -->
          <div v-if="props.ticket.u_images" class="mb-4">
            <h5 class="mb-2">
              <i class="fas fa-image me-2 text-primary"></i>Immagine allegata:
            </h5>
            <div class="text-center p-3 border rounded bg-light">
              <a :href="`/storage/${ticket.u_images}`" target="_blank">
                <img :src="`/storage/${ticket.u_images}`" alt="Ticket image" class="img-fluid rounded w-50">
              </a>
            </div>
          </div>

          <h5 class="mb-3">
            <i class="fas fa-pen-to-square me-2 text-primary"></i>Modifica informazioni
          </h5>

          <form @submit.prevent="submit">
            <div class="row g-3">
              <!-- Progetto -->
              <div class="col-md-6 mb-3">
                <label class="form-label">
                  <i class="fas fa-project-diagram me-2 text-primary"></i>Progetto
                </label>
                <select v-model="form.project_id" class="form-select">
                  <option disabled value="">
                    -- Seleziona Progetto --
                  </option>
                  <option v-for="project in props.projects" :key="project.id" :value="project.id">
                    {{ project.name }}
                  </option>
                </select>
                <div v-if="form.errors.project_id" class="text-danger small mt-1">
                  <i class="fas fa-exclamation-circle me-1"></i>{{ form.errors.project_id }}
                </div>
              </div>

              <!-- Area -->
              <div class="col-md-6 mb-3">
                <label class="form-label">
                  <i class="fas fa-layer-group me-2 text-primary"></i>Area
                </label>
                <select v-model="form.area_id" class="form-select">
                  <option disabled value="">
                    -- Seleziona Area --
                  </option>
                  <option v-for="area in props.areas" :key="area.id" :value="area.id">
                    {{ area.name }}
                  </option>
                </select>
                <div v-if="form.errors.area_id" class="text-danger small mt-1">
                  <i class="fas fa-exclamation-circle me-1"></i>{{ form.errors.area_id }}
                </div>
              </div>

              <!-- Stato -->
              <div class="col-md-6 mb-3">
                <label class="form-label">
                  <i class="fas fa-tasks me-2 text-primary"></i>Stato
                </label>
                <select v-model="form.status_id" class="form-select">
                  <option disabled value="">
                    -- Seleziona Stato --
                  </option>
                  <option v-for="status in props.statuses" :key="status.id" :value="status.id">
                    {{ status.name }}
                  </option>
                </select>
                <div v-if="form.errors.status_id" class="text-danger small mt-1">
                  <i class="fas fa-exclamation-circle me-1"></i>{{ form.errors.status_id }}
                </div>
              </div>

              <!-- Tecnico assegnato -->
              <div class="col-md-6 mb-3">
                <label class="form-label">
                  <i class="fas fa-user-cog me-2 text-primary"></i>Assegnato a
                </label>
                <select v-model="form.assigned_to" class="form-select">
                  <option disabled value="">
                    -- Seleziona Tecnico --
                  </option>
                  <option v-for="tech in props.technicians" :key="tech.id" :value="tech.id">
                    {{ tech.name }}
                  </option>
                </select>
                <div v-if="form.errors.assigned_to" class="text-danger small mt-1">
                  <i class="fas fa-exclamation-circle me-1"></i>{{ form.errors.assigned_to }}
                </div>
              </div>
            </div>


            <div class="d-flex justify-content-end mt-4">
              <PrimaryButton type="submit" :disabled="form.processing" class="btn-success">
                <i class="fas fa-save me-2"></i>Salva Modifiche
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>

      <!-- Mini form per aggiungere commento -->
      <div class="card shadow mt-4 mb-4">
        <div class="card-header bg-light py-3">
          <h4 class="mb-0">
            <i class="fas fa-comment-dots me-2"></i>Aggiungi Commento
          </h4>
        </div>
        <div class="card-body">
          <form @submit.prevent="submitComment">
            <div class="mb-3">
              <label class="form-label">
                <i class="fas fa-pen me-2 text-primary"></i>Testo del commento
              </label>
              <textarea v-model="commentForm.content" class="form-control" rows="3"
                placeholder="Scrivi un commento..."></textarea>
              <div v-if="commentForm.errors.content" class="text-danger small mt-1">
                <i class="fas fa-exclamation-circle me-1"></i>{{ commentForm.errors.content }}
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <PrimaryButton type="submit" :disabled="commentForm.processing">
                <i class="fas fa-paper-plane me-2"></i>Aggiungi Commento
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>
      <!-- Sezione Commenti -->
      <div class="card shadow">
        <div class="card-header bg-light py-3">
          <h4 class="mb-0">
            <i class="fas fa-comments me-2"></i>Commenti
            <span v-if="props.ticket.comments && props.ticket.comments.length"
              class="badge bg-primary ms-2 rounded-pill">
              {{ props.ticket.comments.length }}
            </span>
          </h4>
        </div>
        <div class="card-body">
          <div v-if="props.ticket.comments && props.ticket.comments.length" class="comments-container">
            <div v-for="comment in props.ticket.comments" :key="comment.id"
              class="comment p-3 mb-3 border rounded bg-light position-relative">
              <div class="d-flex align-items-center mb-2">
                <i class="fas fa-user-circle me-2 text-primary fs-5"></i>
                <strong>{{ comment.user.name }}</strong>
              </div>
              <p class="ms-4 mb-3">{{ comment.content }}</p>
              <div class="d-flex justify-content-between align-items-center mt-2">
                <small class="text-muted">
                  <i class="far fa-clock me-1"></i>{{ new Date(comment.created_at).toLocaleString() }}
                </small>
                <button @click="deleteComment(comment.id)" class="btn btn-sm btn-outline-danger"
                  title="Elimina commento">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-4">
            <i class="far fa-comment-dots text-muted mb-3" style="font-size: 3rem;"></i>
            <p class="text-muted">Nessun commento ancora.</p>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
.comments-container {
  max-height: 400px;
  overflow-y: auto;
}

.comment {
  transition: all 0.2s ease;
}

.comment:hover {
  background-color: #f8f9fa !important;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.border-start.border-primary {
  background-color: rgba(13, 110, 253, 0.03);
}

.ticket-image {
  max-height: 300px;
  object-fit: contain;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.ticket-image:hover {
  transform: scale(1.02);
  cursor: pointer;
}
</style>