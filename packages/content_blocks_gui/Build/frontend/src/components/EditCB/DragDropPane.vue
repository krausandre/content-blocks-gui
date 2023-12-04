<template>
  <div class="drag-drop-pane">
    <draggable
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
    </draggable>
  </div>
  <pre>
<!-- {{ contentBlockStore.getFields }} -->
{{ fieldsList }}
  </pre>
</template>

<script setup>
import draggable from "vuedraggable";

import {useContentBlockStore} from "@/store/contentBlockStore";
import {FieldTypes} from "@/models/FieldTypes";

const fieldsList = useContentBlockStore().getFields;
const contentBlockStore = useContentBlockStore();

const change = (evt) => contentBlockStore.setFields(fieldsList);

</script>
<style scoped></style>
