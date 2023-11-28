<script setup>
import availableFieldTypes from '@/components/fieldTypes/availableFieldTypes.js';
import Tabs from '@/components/Tabs.vue'
import Tab from '@/components/Tab.vue'
import BaseFieldType from "@/components/fieldTypes/BaseFieldType.vue";
import draggable from "vuedraggable";
import TextFieldType from "@/components/fieldTypes/TextFieldType.vue";

let idGlobal = 0;

const cloneFieldType = (item) => {
  console.log(item);
  return {
    identifier: item.identifier + "_" + idGlobal++,
    componentName: item.componentName,
    label: item.label,
    iconIdentifier: item.iconIdentifier,
    properties: item.properties
  };
}
</script>

<template>
  <Tabs>
    <Tab active="true" title="Settings">
      <form>
        <div class="mb-3">
          <label for="identifier" class="form-label">Identifier</label>
          <input class="form-control" id="identifier" aria-describedby="identifier">
        </div>
        <div class="mb-3">
          <label for="vendor" class="form-label">Vendor</label>
          <input class="form-control" id="vendor" aria-describedby="vendor">
        </div>
        <div class="mb-3">
          <label for="group" class="form-label">Group</label>
            Group
          <input class="form-control" id="group" aria-describedby="group">
        </div>
        <div class="mb-3">
          <label for="typename" class="form-label">Type Name</label>
          <input class="form-control" id="typename" aria-describedby="typename">
        </div>
        <div class="mb-3">
          <label for="table" class="form-label">Table</label>
          <input class="form-control" id="table" aria-describedby="table">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </Tab>
    <Tab title="Components">
      <h2>Input Fields</h2>
      <draggable
          class="dragArea list-group"
          :list="availableFieldTypes.inputFields"
          :group="{ name: 'people', pull: 'clone', put: false }"
          :clone="cloneFieldType"
          item-key="identifier"
      >
        <template #item="{ element: item }">
          <component :is="item.componentName" :label="item.label" :icon-identifier="item.iconIdentifier"/>
        </template>
      </draggable>
    </Tab>
    <Tab title="Basics">
      @todo basics
    </Tab>
  </Tabs>

</template>

<style scoped>
</style>
