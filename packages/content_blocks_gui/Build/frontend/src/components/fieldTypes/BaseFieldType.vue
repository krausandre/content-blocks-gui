<template>
  <div :class="`fieldtype px-2 py-1 me-2 mb-1 ${globalPropertiesStore.getCurrentSelectedFieldIdentifier === props.identifier ? 'is-selected' : ''} `">
    <div
        :class="`${props.isNested ? 'dragabble-nested' : ''}`"
        @click="handleComponentClick"
        @dragenter="handleDragEnter"
        @dragleave="handleDragLeave"
    >
      <div class="d-flex flex-row ">
        <Icon :identifier="props.iconIdentifier" />
        <span class="ms-2">{{ props.label }}</span>
      </div>
        <draggable v-if="props.isNested"
            class="dragArea nested list-group"
            :list="nestedFields"
            :group="{ name: 'fieldTypes', put: true }"
            item-key="identifier">
            <template #item="{ element: item }">
              <component
                :isInDragArea="true"
                :is="FieldTypes.componentName(item)"
                :identifier="item.identifier"
                :label="FieldTypes.typeLabel(item) + ' (' + item.identifier + ')'"
                :icon-identifier="FieldTypes.iconIdentifier(item)"/>
            </template>
        </draggable>
    </div>
  </div>
</template>

<script setup lang="ts">
import Icon from "@/components/icons/Icon.vue";
import {ref} from "vue";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import draggable from "vuedraggable";
import {useContentBlockStore} from "@/store/contentBlockStore";
import BaseFieldType from "@/components/fieldTypes/BaseFieldType.vue";
import {FieldTypes} from "@/models/FieldTypes";


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
  isNested: {
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

const contentBlockStore = useContentBlockStore();

const change = function(evt: any) {
    // contentBlockStore.setFields(nestedFields.value);
    // console.log("FieldsList: ", this.fieldsList);
}

let nestedFields = ref([]);

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
