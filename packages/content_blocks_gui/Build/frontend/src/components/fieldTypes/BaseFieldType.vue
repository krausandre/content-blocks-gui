<template>
  <div class="fieldtype textfieldtype border-1 border px-2 py-1 border-dark me-2 mb-1">
    <div
        class="d-flex flex-row "
        @click="handleComponentClick"
        @dragenter="handleDragEnter"
        @dragleave="handleDragLeave"
    >
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
  isInDragArea: {
    type: Boolean,
    default: false,
  },
});

const handleComponentClick = () => {
  if(!props.isInDragArea) {
    return;
  }
  console.log("Handle component click: " + props.identifier);
}

const handleDragEnter = () => {
  if(!props.isInDragArea) {
    return;
  }
  console.log("Handle drag enter: " + props.identifier);
}

const handleDragLeave = () => {
  if(!props.isInDragArea) {
    return;
  }
  console.log("Handle drag leave: " + props.identifier);
}
</script>

<style>

</style>
