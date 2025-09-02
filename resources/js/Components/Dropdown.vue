<script setup>
import { computed, onMounted, ref } from 'vue';
import * as bootstrap from 'bootstrap';

const props = defineProps({
  align: {
    type: String,
    default: 'right',
  },
  width: {
    type: String,
    default: '48',
  },
  contentClasses: {
    type: String,
    default: 'py-1 bg-white',
  },
});

const dropdownElement = ref(null);
const dropdownInstance = ref(null);
let isInitialized = false;

onMounted(() => {
  if (!isInitialized && dropdownElement.value) {
    dropdownInstance.value = new bootstrap.Dropdown(dropdownElement.value);
    isInitialized = true;
  }
});

const alignmentClasses = computed(() => {
  if (props.align === 'left') {
    return 'dropdown-menu-start';
  } else if (props.align === 'right') {
    return 'dropdown-menu-end';
  } else {
    return '';
  }
});

const widthClass = computed(() => {
  return {
    48: 'dropdown-menu-lg-end',
  }[props.width.toString()];
});

const toggleDropdown = () => {
  if (dropdownInstance.value) {
    dropdownInstance.value.toggle();
  }
};
</script>

<template>
  <div class="dropdown">
    <div ref="dropdownElement" data-bs-toggle="dropdown" aria-expanded="false">
      <slot name="trigger" />
    </div>

    <ul class="dropdown-menu" :class="[widthClass, alignmentClasses, contentClasses]">
      <slot name="content" />
    </ul>
  </div>
</template>
