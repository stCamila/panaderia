<template>
  <input type="checkbox" :value="value" v-model="proxyChecked"
         class="text-pink-600 form-checkbox focus:shadow-outline-pink focus:border-pink-800 focus:outline-none dark:focus:shadow-outline-gray" />
</template>

<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
  checked: {
    type: [Array, Boolean],
    default: false,
  },
  value: {
    default: null,
  },
});

const proxyChecked = computed({
  get() {
    return props.checked;
  },

  set(val) {
    emit('update:checked', val);
  },
});
</script>
