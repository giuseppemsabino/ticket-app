  <script setup>
  const props = defineProps({
    type: {
      type: String,
      default: 'button'
    }
  });
</script>

<template>
  <button :type="type" class="d-inline-flex align-items-center btn btn-dark text-uppercase fw-semibold text-white">
    <slot />
  </button>
</template>
