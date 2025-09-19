<script setup>
defineProps({
  message: {
    type: String,
  },
});
</script>

<template>
  <div v-show="message">
    <p class="small text-danger invalid-feedback d-block">
      {{ message }}
    </p>
  </div>
</template>
