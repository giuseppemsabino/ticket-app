  <script setup>
  const props = defineProps({
    type: {
      type: String,
      default: 'button'
    }
  });
</script>

<template>
  <button :type="type" class="d-inline-flex align-items-center btn  text-uppercase fw-semibold ">
    <slot />
  </button>
</template>

<style scoped>
.btn {
  background-color: #00285B;
  color: #FFDF48 !important;
  border: none;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  transition: background-color 0.3s ease;
}


.btn:hover {
  background-color: #FFDF48;
  color: #00285B !important;
  text-decoration: none;
}
</style>