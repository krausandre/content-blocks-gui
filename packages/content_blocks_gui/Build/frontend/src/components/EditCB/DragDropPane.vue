<template>
  <div class="drag-drop-pane">
    <VueDraggable
        class="dragArea list-group"
        v-model="fieldsList"
        :animation="150"
        group="fieldTypes"
    >
      <div
        v-for="item in fieldsList"
        :key="item.id"
        class="d-flex flex-row draggableItem gap-2"
      >
        <Icon :identifier="item.iconIdentifier" /> {{ item.type }}
      </div>
    </VueDraggable>
  </div>
  <pre>
{{ fieldsList }}
  </pre>
</template>

<script setup>
import {VueDraggable} from "vue-draggable-plus";

import {useContentBlockStore} from "@/store/contentBlockStore";
import {FieldTypes} from "@/models/FieldTypes";
import Icon from "@/components/icons/Icon.vue";

const contentBlockStore = useContentBlockStore();
const fieldsList = contentBlockStore.getFields;

const change = (evt) => contentBlockStore.setFields(fieldsList);

</script>

<style scoped>
.draggableItem {
  background-color: #f4f4f4;
  border: 1px solid #ccc;
  padding: 10px;
  margin: 5px 0;
}
</style>
