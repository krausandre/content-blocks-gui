<template>
  <!-- @todo group people? -->
  <draggable
    class="dragArea list-group leftpane-components"
    :list="FieldTypes.draggableVanillaFieldTypes()"
    :group="{ name: 'people', pull: 'clone', put: false }"
    :clone="cloneFieldType"
    :sort="false"
    item-key="identifier"
  >
    <template #item="{ element: item }">
      <component
        :is="FieldTypes.componentName(item)"
        :label="FieldTypes.typeLabel(item)"
        :icon-identifier="FieldTypes.iconIdentifier(item)"
      />
    </template>
  </draggable>
</template>

<script setup lang='ts'>
import draggable from "vuedraggable";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import {FieldTypes} from "@/models/FieldTypes";

const globalPropertiesStore = useGlobalPropertiesStore();

let idGlobal = 0;

const cloneFieldType = (item: any) => {
  // deep copy ;)
  const newItem = JSON.parse(JSON.stringify(item));
  const identifier = (item.type ?? 'existing').toLowerCase() + "_" + idGlobal++;
  newItem.identifier = identifier;
  globalPropertiesStore.setCurrentSelectedFieldIdentifier(identifier);
  return newItem;
}
</script>

<style scoped>
</style>
