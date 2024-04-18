<template>
  <VueDraggable
    class="dragArea list-group leftpane-components"
    :animation="150"
    :group="{ name: 'fieldTypes', pull: 'clone', put: false }"
    :sort="false"
    v-model="filteredFieldTypes" >
    <div
      v-for="fieldType in filteredFieldTypes"
      :key="fieldType.id"
      class="d-flex flex-row draggableItem gap-2">
      <Icon :identifier="fieldType.iconIdentifier" /> {{ fieldType.type }}
    </div>
  </VueDraggable>
</template>

<script setup lang='ts'>
import {VueDraggable} from "vue-draggable-plus";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import {FieldTypes} from "@/models/FieldTypes";
import {computed, ref} from "vue";
import Icon from "@/components/icons/Icon.vue";

const globalPropertiesStore = useGlobalPropertiesStore();

const filteredFieldTypes = computed(() => {
  return FieldTypes.draggableVanillaFieldTypes().filter(ft => ft.type);
});

let idGlobal = 0;

const cloneFieldType = (item: any) => {
  // deep copy ;)
  const newItem = JSON.parse(JSON.stringify(item));
  const identifier = (item.type ?? 'existing').toLowerCase() + "_" + idGlobal++;
  newItem.identifier = identifier;
  globalPropertiesStore.setCurrentSelectedFieldIdentifier(identifier);
  console.log("newItem:" + newItem);
  return newItem;
}

function onClone(element: Record<'name' | 'id', string>) {
  console.log('onClone', element);

  const len = 1
  const newElement = {
    name: `${element.name}-clone-${len}`,
    id: `${element.id}-clone-${len}`,
    identifier: "element" + "_" + idGlobal++
  }
  console.log("newElement:" + JSON.stringify(newElement));
  return element;
  // return {
  //   name: `${element.name}-clone-${len}`,
  //   id: `${element.id}-clone-${len}`,
  //   identifier: "element" + "_" + idGlobal++
  // }
}
</script>

<style scoped>
.draggableItem {
  background-color: #f4f4f4;
  border: 1px solid #ccc;
  padding: 10px;
  margin: 5px 0;
}
</style>
