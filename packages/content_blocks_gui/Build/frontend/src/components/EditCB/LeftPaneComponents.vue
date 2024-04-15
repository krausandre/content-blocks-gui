<template>
  <VueDraggable
    class="dragArea list-group leftpane-components"
    :list="FieldTypes.draggableVanillaFieldTypes()"
    :group="{ name: 'fieldTypes', pull: 'clone', put: false }"
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
  </VueDraggable>
</template>

<script setup lang='ts'>
import {VueDraggable} from "vue-draggable-plus";
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
