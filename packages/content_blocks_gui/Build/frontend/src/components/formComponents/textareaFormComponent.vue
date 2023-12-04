<template>
  <div class="mb-3">
    <label
        :for="name"
         class="form-label">
      {{label}}
    </label>
    <Field
        v-slot="{ field }"
        :v-model="name"
        :name="name"
        class="form-control mb-1"
        :rules="rules"
    >
      <textarea
          class="form-control"
          :id="name"
          v-bind="field"
          :rows="rows"
          :name="name"
      />
    </Field>
    <ErrorMessage class="test text-danger" :name="name"/>
  </div>
</template>

<script setup>
  import {defineProps} from "vue";
  import {ErrorMessage, Field} from "vee-validate";

  const props = defineProps({
      label: {
          type: String,
          required: false
      },
      value: {
          type: String,
          required: true
      },
      rows: {
          type: Number,
          required: false,
          default: 5
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
