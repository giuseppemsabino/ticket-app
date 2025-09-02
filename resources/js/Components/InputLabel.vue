<script setup>
defineProps({
  value: {
    type: String,
  },
});
</script>

<template>
  <label class="form-label small fw-medium text-dark">
    <span v-if="value">{{ value }}</span>
    <span v-else>
      <slot />
    </span>
  </label>
</template>
