<template>
  <div :class="`fieldtype px-2 py-1 me-2 mb-1 ${globalPropertiesStore.getCurrentSelectedFieldIdentifier === props.identifier ? 'is-selected' : ''}`">
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
import {ref} from "vue";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";

const globalPropertiesStore = useGlobalPropertiesStore();
let isActive = ref(false);

const props = defineProps({
  iconIdentifier: {
    type: String,
    required: true,
  },
  identifier: {
    required: false,
    type: String,
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

  isActive.value = !isActive.value;
  globalPropertiesStore.setCurrentSelectedFieldIdentifier(props.identifier as string);
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
.fieldtype {
  border: 1px solid var(--bs-dark);
}

.fieldtype.is-selected {
  border-color: var(--cb-primary);
  background-color: var(--bs-warning-bg-subtle);
}
</style>
