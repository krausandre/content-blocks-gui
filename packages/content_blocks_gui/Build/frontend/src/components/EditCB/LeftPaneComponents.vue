<template>
  <draggable
      class="dragArea list-group"
      :list="availableFieldTypes.inputFields"
      :group="{ name: 'people', pull: 'clone', put: false }"
      :clone="cloneFieldType"
      :sort="false"
      item-key="identifier"
  >
    <template #item="{ element: item }">
      <component :is="item.componentName" :label="item.label" :icon-identifier="item.iconIdentifier"/>
    </template>
  </draggable>
</template>

<script setup lang='ts'>
import availableFieldTypes from '@/components/fieldTypes/availableFieldTypes.js';
import draggable from "vuedraggable";

let idGlobal = 0;

const cloneFieldType = (item: any) => {
  return {
    identifier: item.identifier + "_" + idGlobal++,
    componentName: item.componentName,
    label: item.label,
    iconIdentifier: item.iconIdentifier,
    properties: item.properties
  };
}
</script>

<style scoped>
</style>
