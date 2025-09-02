<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  active: {
    type: Boolean,
  },
});

const classes = computed(() =>
  props.active
    ? 'd-block w-100 ps-3 pe-4 py-2 border-start border-primary text-start fs-6 fw-medium text-primary bg-light nav-link active'
    : 'd-block w-100 ps-3 pe-4 py-2 border-start border-transparent text-start fs-6 fw-medium text-secondary nav-link hover-dark',
);
</script>

<template>
  <Link :href="href" :class="classes">
  <slot />
  </Link>
</template>
