<template>
  <div class="mb-3">
    <Field
      :name="name"
      :type="type"
      :rules="rules"
      :aria-describedby="name"
      class="form-control mb-1"
    />
    <ErrorMessage class="test text-danger" :name="name"/>
  </div>
</template>

<script setup>
import {defineProps, computed, ref} from 'vue';
import {Field, ErrorMessage} from 'vee-validate';

const props = defineProps({
  label: {
    type: String,
    required: false
  },
  type: {
    type: String,
    required: false,
    default: 'text'
  },
  name: {
    type: String,
    required: true
  },
  rules: {
    type: String,
    required: false,
    default: ''
  }
});
</script>
