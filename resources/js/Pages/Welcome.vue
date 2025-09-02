<script setup>
import { Head } from '@inertiajs/vue3';
import Login from './Auth/Login.vue';


defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
  laravelVersion: {
    type: String,
    required: true,
  },
  phpVersion: {
    type: String,
    required: true,
  },
});

function handleImageError() {
  document.getElementById('screenshot-container')?.classList.add('!hidden');
  document.getElementById('docs-card')?.classList.add('!row-span-1');
  document.getElementById('docs-card-content')?.classList.add('!flex-row');
  document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>

  <Head title="Benvenuto" />
  <div class="bg-light text-secondary dark-mode">
    <img id="background" class="position-absolute ms-n5 top-0"
      src="https://laravel.com/assets/img/welcome/background.svg" />

    <main>
      <Login />
    </main>

  </div>
</template>
