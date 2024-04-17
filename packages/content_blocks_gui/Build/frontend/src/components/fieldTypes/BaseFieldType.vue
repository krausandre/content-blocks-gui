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
        <Icon identifier="actions-delete" @click.stop="removeField(props.identifier)"/>
      </div>
      <VueDraggable
        v-if="props.isNested"
        v-model="nestedFields"
        ghostClass="ghost"
        @change="addNestedFields(props.identifier ?? '', null)"
        :group="{ name: 'fieldTypes', put: true }"
        @click.stop
        class="dragArea nested list-group">
        <div class="test">
          Testing
        </div>
      </VueDraggable>
       <VueDraggable v-if="props.isNested"
            class="dragArea nested list-group"
            :list="nestedFields"
            :group="{ name: 'fieldTypes', put: true }"
            @click.stop>
            <template #item="{ element: item }">
              <component
                :isInDragArea="true"
                :is="FieldTypes.componentName(item)"
                :identifier="item.identifier"
                :label="FieldTypes.typeLabel(item) + ' (' + item.identifier + ')'"
                :icon-identifier="FieldTypes.iconIdentifier(item)"/>
            </template>
        </VueDraggable>

    </div>
  </div>
</template>

<script setup lang="ts">
import Icon from "@/components/icons/Icon.vue";
import {ref} from "vue";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import {VueDraggable} from "vue-draggable-plus";
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
const fieldsList = useContentBlockStore().getFields;

let nestedFields = ref([]);

const removeField = function(id) {
  console.log("DELETE PRESSED: " + id);
  let tempState = fieldsList;
  tempState.forEach(function(elem, index) {
      let elemItems = elem.items;
      if (elem.identifier  === id) {
        tempState.splice(index, 1)
      }
  });
  contentBlockStore.setFields(fieldsList);
}

const addNestedFields = function(id, item) {
  let tempState = fieldsList;
  tempState.forEach(function(elem, index) {
    if (elem.identifier  === id) {
      elem.items = nestedFields.value;
    }
  });
  console.log(nestedFields.value)
  contentBlockStore.setFields(fieldsList);
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
