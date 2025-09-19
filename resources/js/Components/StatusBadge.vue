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
    :class="`${size} badge bg-` + (status.id === 1 ? 'success' : status.id === 2 ? 'warning' : status.id === 3 ? 'secondary' : 'danger')">
    {{ statusName }}
  </span>
</template>