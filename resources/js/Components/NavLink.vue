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
    ? 'd-inline-flex align-items-center px-2 pt-1 border-bottom border-primary small fw-medium text-dark nav-link active'
    : 'd-inline-flex align-items-center px-2 pt-1 border-bottom border-transparent small fw-medium text-secondary nav-link hover-dark',
);
</script>

<template>
  <Link :href="href" :class="classes">
  <slot />
  </Link>
</template>
