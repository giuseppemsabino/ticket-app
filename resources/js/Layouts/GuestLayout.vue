<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="d-flex min-vh-100 flex-column align-items-center bg-light pt-4 pt-sm-0 mt-5">
    <div>
      <Link href="/">
      <ApplicationLogo class="h-20 w-20 text-secondary" />
      </Link>
    </div>

    <div class="mt-4  overflow-hidden bg-white p-sm-4 shadow card sm-max-w-md rounded">
      <slot />
    </div>
  </div>
</template>
