<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  href: {
    type: String,
    required: true,
  },
  method: {
    type: String,
    default: 'get',
  },
  as: {
    type: String,
    default: 'a',
  }
});
</script>

<template>
  <li>
    <Link :href="href" :method="method" :as="as" class="dropdown-item">
    <slot />
    </Link>
  </li>
</template>
