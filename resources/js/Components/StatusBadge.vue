<script setup>
const props = defineProps({
  statusId: Number,
  statuses: Array,
  size: String,
})

const status = props.statuses.find(
  (status) => status.id === props.statusId
);
const statusName = status ? status.name : "N/A";
</script>

<template>
  <span v-if="status"
    :class="`${size} badge bg-` + (status.id === 1 ? 'info' : status.id === 2 ? 'success' : status.id === 3 ? 'success' : 'danger')">
    {{ statusName }}
  </span>
</template>