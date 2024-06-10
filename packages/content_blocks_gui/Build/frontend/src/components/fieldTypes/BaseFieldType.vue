<template>
  <div :class="`fieldtype px-2 py-1 mb-1 ${globalPropertiesStore.getCurrentSelectedFieldIdentifier === props.identifier ? 'is-selected' : ''} `">
    <div
        :class="`${props.isNested ? 'dragabble-nested' : ''}`"
        @click="handleComponentClick"
        :key="props.identifier"
        @dragenter="handleDragEnter"
        @dragleave="handleDragLeave"
        @drop="handleDrop(props.identifier)"
        @change="handleDrop(props.identifier)"
    >
      <div class="d-flex flex-row ">
        <Icon :identifier="props.iconIdentifier" />
        <span class="ms-2">{{ props.label }}</span>
        <Icon identifier="actions-delete" @click.stop="removeField(props.identifier)"/>
      </div>
        <draggable v-if="props.isNested"
            :key="props.identifier"
            class="dragArea nested list-group"
            :list="nestedFields"
            :group="{ name: 'fieldTypes', put: true, sort: false }"
            @change="addNestedFields(props.identifier)"
            @click.stop
            >
            <template #item="{ element: item }">
              <component
                :key="item.identifier"
                :isInDragArea="true"
                :is="FieldTypes.componentName(item)"
                :identifier="item.identifier"
                :label="FieldTypes.typeLabel(item) + ' (' + item.identifier + ')'"
                :icon-identifier="FieldTypes.iconIdentifier(item)"
                @click.stop
              />
            </template>
        </draggable>

    </div>
  </div>
</template>

<script setup lang="ts">
import Icon from "@/components/icons/Icon.vue";
import {ref} from "vue";
import {reactive} from "vue";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import draggable from "vuedraggable";
import {useContentBlockStore} from "@/store/contentBlockStore";
import BaseFieldType from "@/components/fieldTypes/BaseFieldType.vue";
import {FieldTypes} from "@/models/FieldTypes";

const globalPropertiesStore = useGlobalPropertiesStore();
const contentBlockStore = useContentBlockStore();
const fieldsList = reactive(useContentBlockStore().getFields);
let isActive = ref(false);
let nestedFields = ref([]);

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
  // console.log("Handle component click: " + props.identifier);
}

const handleDragEnter = () => {
  if(!props.isInDragArea) {
    return;
  }
  // console.log("Handle drag enter: " + props.identifier);
}

const handleDragLeave = () => {
  if(!props.isInDragArea) {
    return;
  }
}

const handleDrop = function(id) {
//  @todo get nested fields with when moving nested draggables outside of nested draggables
//   console.log(nestedFields.value);
//   console.log(props.identifier);
// @todo: fetch recursive all nested
  fetchNestedFieldsFromState(props.identifier);
//   let nestedCollections = fetchNestedCollectionsRecursive(props.identifier);
//   console.log(nestedCollections);
//   for (let i = 0; i < nestedCollections.length; i++) {
//     fetchNestedFieldsFromState(nestedCollections[i]);
//     // console.log(nestedCollections[i]);
//   }
  console.log(fieldTypes);
  // console.log(fieldTypes);
  // console.log(fetchNestedCollectionsRecursive(props.identifier));
}

const updateMainElement = () => {
  console.log('updated');
}

const removeField = function(id) {
  var tempState = useContentBlockStore().getFields;
  findAndRemoveField( tempState, id);
  function findAndRemoveField( array , id) {
    for (let index in array) {
      if (array[index].identifier == id){
          array.splice(index, 1)
      }
      else {
        findAndRemoveField(array[index].items, id )
      }
    }
  }
  contentBlockStore.setFields(fieldsList);
}

const addNestedFields = function(id) {
  var tempState = useContentBlockStore().getFields;
  findAndAddNestedFields( tempState, id);
  function findAndAddNestedFields( array , id) {
    for (let index in array) {
        if (array[index].identifier == id){
          array[index].items = nestedFields.value;
          fetchNestedFieldsFromState(id);
        }
        else {
          findAndAddNestedFields(array[index].items, id )
        }
      }
    }
  contentBlockStore.setFields(fieldsList);
}

const fetchNestedFieldsFromState = function(id) {
  var tempState = useContentBlockStore().getFields;
  findNestedFieldsRecursive( tempState, id);
  function findNestedFieldsRecursive( array , id) {
    for (let index in array) {
      if (array[index].identifier == id){
        nestedFields.value = array[index].items;
      }
      else {
        findNestedFieldsRecursive(array[index].items, id )
      }
    }
  }
  contentBlockStore.setFields(fieldsList);
}

const fetchNestedCollectionsRecursive = function(id) {
  var arrayOfNestedCollections = [];
  var tempState = useContentBlockStore().getFields;
  findAndAddNestedFields(tempState);
  function findAndAddNestedFields( array) {
    for (let index in array) {
      if (array[index].type == 'Collection'){
        arrayOfNestedCollections.push(array[index].identifier);
        if ((array[index].items).length > 0)
        findAndAddNestedFields(array[index].items)
      }
    }
  }
  return arrayOfNestedCollections;
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
