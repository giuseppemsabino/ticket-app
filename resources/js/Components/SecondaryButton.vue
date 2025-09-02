<script setup>
defineProps({
  type: {
    type: String,
    default: 'button',
  },
});
</script>

<template>
  <button :type="type"
    class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center text-uppercase fw-semibold">
    <slot />
  </button>
</template>
