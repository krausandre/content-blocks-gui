<template>
  <div class="drag-drop-pane">
    <VueDraggable
        class="dragArea list-group"
        :list="fieldsList"
        group="fieldTypes"
        @change="change"
        item-key="identifier"
    >
      <template #item="{ element: item }">
        <component
            :is-in-drag-area="true"
            :is="FieldTypes.componentName(item)"
            :identifier="item.identifier"
            :label="FieldTypes.typeLabel(item) + ' (' + item.identifier + ')'"
            :icon-identifier="FieldTypes.iconIdentifier(item)"
        />
      </template>
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

const contentBlockStore = useContentBlockStore();
const fieldsList = contentBlockStore.getFields;

const change = (evt) => contentBlockStore.setFields(fieldsList);

</script>
<style scoped></style>
