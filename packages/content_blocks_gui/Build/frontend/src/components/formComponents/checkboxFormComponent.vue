<template>
  <div class="mb-3 form-check">
    <Field
      :name="name"
      :id="name"
      type="checkbox"
      :rules="rules"
      :aria-describedby="name"
      :checked="isChecked"
      class="form-check-input"
    />
    <label
        class="form-check-label"
        :for="name">
      {{label}}
    </label>
    <ErrorMessage class="test text-danger" :name="name"/>
  </div>
</template>

<script setup>
  import { defineProps } from "vue";
  import {Field, ErrorMessage} from 'vee-validate';

  const props = defineProps({
    label: {
      type: String,
      required: false,
    },
    isChecked: {
      type: Boolean,
      required: false,
    },
    name: {
      type: String,
      required: true,
    },
    rules: {
      type: String,
      required: false,
      default: "",
    }
  });
</script>
