<script setup>
import {
  Link,
  Head
} from '@inertiajs/vue3';
</script>


<template>

  <Head title="Dashboard Super Admin">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </Head>



  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="row row-cols-1 row-cols-md-2 g-4">

          <!-- Pulsantone Utenti -->
          <div class="col">
            <Link href="/users" class="text-decoration-none">
            <div class="card dashboard-card shadow h-100 py-5 text-center hover-effect">
              <div class="card-body d-flex flex-column justify-content-center">
                <div class="icon-container mb-4">
                  <i class="fa-solid fa-users fa-5x"></i>
                </div>
                <h2 class="card-title fw-bold">UTENTI</h2>
                <p class="card-text text-muted mt-2">
                  Gestisci utenti, tecnici e amministratori
                </p>
              </div>
            </div>
            </Link>
          </div>

          <!-- Pulsantone Tickets -->
          <div class="col">
            <Link href="/tickets" class="text-decoration-none">
            <div class="card dashboard-card shadow h-100 py-5 text-center hover-effect">
              <div class="card-body d-flex flex-column justify-content-center">
                <div class="icon-container mb-4">
                  <i class="fa-solid fa-ticket fa-5x"></i>
                </div>
                <h2 class="card-title fw-bold">TICKETS</h2>
                <p class="card-text text-muted mt-2">
                  Visualizza e gestisci tutte le richieste di assistenza
                </p>
              </div>
            </div>
            </Link>
          </div>

        </div>
      </div>
    </div>
  </div>



</template>

<style scoped>
.dashboard-card {
  border-radius: 15px;
  border: 3px solid transparent;
}

.hover-effect:hover {
  border-color: var(--bs-primary);
}

.icon-container {
  height: 100px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.fa-users,
.fa-ticket {
  color: #FFDF48;
}
</style>