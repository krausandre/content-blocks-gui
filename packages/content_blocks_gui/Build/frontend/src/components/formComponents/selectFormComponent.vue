<template>
  <label
      :for="name"
      class="form-label">
    {{label}}
  </label>
  <select
        class="form-select mb-1"
        :value="value"
    >
        <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
        >
            {{ option.label }}
        </option>
    </select>
</template>

<script setup>
  import {defineProps} from "vue";

  const props = defineProps({
      label: {
          type: String,
          required: false
      },
      options: {
          type: Array,
          required: true
      },
      value: {
          type: String,
          required: true
      },
      name: {
        type: String,
        required: true
      }
  });
</script>
