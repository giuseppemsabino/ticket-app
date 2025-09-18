<template>
  <div class="container mt-5">
    <h1 class="mb-4">Create User</h1>

    <form @submit.prevent="submitForm">
      <!-- Name -->
      <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" class="form-control" v-model="form.name" required />
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" v-model="form.email" required />
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" v-model="form.password" required />
      </div>

      <!-- Roles (checkbox N:N) -->
      <div class="mb-3">
        <label class="form-label">Roles</label>
        <div class="form-check" v-for="role in roles" :key="role.id">
          <input
            class="form-check-input"
            type="checkbox"
            :id="'role-' + role.id"
            :value="role.id"
            v-model="form.roles"
          />
          <label class="form-check-label" :for="'role-' + role.id">{{ role.name }}</label>
        </div>
      </div>

      <!-- Projects (checkbox N:N) -->
      <div class="mb-3">
        <label class="form-label">Projects</label>
        <div class="form-check" v-for="project in projects" :key="project.id">
          <input
            class="form-check-input"
            type="checkbox"
            :id="'project-' + project.id"
            :value="project.id"
            v-model="form.projects"
          />
          <label class="form-check-label" :for="'project-' + project.id">{{ project.name }}</label>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Create User</button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    roles: Array,
    projects: Array
  },
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        roles: [],
        projects: []
      }
    };
  },
  methods: {
    submitForm() {
      // Invia i dati a Laravel usando Inertia
      this.$inertia.post('/users', this.form)
        .then(() => {
          // opzionale: resettare il form o mostrare messaggio
          this.form.name = '';
          this.form.email = '';
          this.form.password = '';
          this.form.roles = [];
          this.form.projects = [];
        })
        .catch(error => {
          console.error('Errore submit:', error);
        });
    }
  }
};
</script>
