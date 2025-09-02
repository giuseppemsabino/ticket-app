<script setup>
import { computed, onMounted, onUnmounted, ref, watch } from 'vue';

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  maxWidth: {
    type: String,
    default: '2xl',
  },
  closeable: {
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(['close']);
const dialog = ref();
const showSlot = ref(props.show);

watch(
  () => props.show,
  () => {
    if (props.show) {
      document.body.style.overflow = 'hidden';
      showSlot.value = true;

      dialog.value?.showModal();
    } else {
      document.body.style.overflow = '';

      setTimeout(() => {
        dialog.value?.close();
        showSlot.value = false;
      }, 200);
    }
  },
);

const close = () => {
  if (props.closeable) {
    emit('close');
  }
};

const closeOnEscape = (e) => {
  if (e.key === 'Escape') {
    e.preventDefault();

    if (props.show) {
      close();
    }
  }
};

onMounted(() => document.addEventListener('keydown', closeOnEscape));

onUnmounted(() => {
  document.removeEventListener('keydown', closeOnEscape);

  document.body.style.overflow = '';
});

const maxWidthClass = computed(() => {
  return {
    sm: 'modal-sm',
    md: 'modal-md',
    lg: 'modal-lg',
    xl: 'modal-xl',
    '2xl': 'modal-xxl',
  }[props.maxWidth];
});
</script>

<template>
  <dialog class="modal fade z-index-modal p-0 min-vh-100 w-100 overflow-auto bg-transparent" ref="dialog">
    <div class="position-fixed top-0 end-0 bottom-0 start-0 z-index-modal overflow-auto p-3 p-sm-0" scroll-region>
      <Transition enter-active-class="fade show" enter-from-class="opacity-0" enter-to-class="opacity-100"
        leave-active-class="fade" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-show="show" class="position-fixed top-0 end-0 bottom-0 start-0 modal-backdrop" @click="close">
          <div class="position-absolute top-0 end-0 bottom-0 start-0 bg-dark opacity-50" />
        </div>
      </Transition>

      <Transition enter-active-class="fade show" enter-from-class="opacity-0" enter-to-class="opacity-100"
        leave-active-class="fade" leave-from-class="opacity-100" leave-to-class="opacity-0">
        <div v-show="show" class="mb-4 modal-content rounded shadow-lg mx-auto w-100" :class="maxWidthClass">
          <slot v-if="showSlot" />
        </div>
      </Transition>
    </div>
  </dialog>
</template>
