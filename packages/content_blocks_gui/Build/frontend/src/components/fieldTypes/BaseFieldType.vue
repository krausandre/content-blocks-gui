<template>
  <div class="fieldtype textfieldtype border-1 border px-2 py-1 border-dark me-2 mb-1">
    <div class="d-flex flex-row " @click="console.log('test')">
      <Icon :identifier="props.iconIdentifier" />
      <span class="ms-2">{{ props.label }}</span>
    </div>
  </div>
</template>

<script setup lang="ts">
import Icon from "@/components/icons/Icon.vue";

const props = defineProps({
  iconIdentifier: {
    type: String,
    required: true,
  },
  identifier: {
    required: false,
  },
  label: {
    type: String,
    required: true,
  },
});
</script>

<style>

</style>
