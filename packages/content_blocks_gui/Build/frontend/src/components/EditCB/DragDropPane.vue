<template>
  <div class="drag-drop-pane">
    <draggable
        class="dragArea list-group"
        :list="fieldsList"
        group="people"
        @change="change"
        item-key="identifier"
    >
      <template #item="{ element: item }">
        <component
            :isInDragArea="true"
            :is="FieldTypes.componentName(item)"
            :identifier="item.identifier"
            :label="FieldTypes.typeLabel(item) + ' (' + item.identifier + ')'"
            :icon-identifier="FieldTypes.iconIdentifier(item)"/>
      </template>
    </draggable>
  </div>
  <pre>
{{ contentBlockStore.getFields }}
{{ fieldsList }}
  </pre>
</template>

<script>
import draggable from "vuedraggable";
import BaseFieldType from "@/components/fieldTypes/BaseFieldType.vue";

import {useContentBlockStore} from "@/store/contentBlockStore";
import {FieldTypes} from "@/models/FieldTypes";

export default {
  name: "clone",
  computed: {
    FieldTypes() {
      return FieldTypes
    }
  },
  display: "Clone",
  order: 2,
  components: {
    BaseFieldType,
    draggable
  },
  data() {
    return {
      fieldsList: useContentBlockStore().getFields,
      contentBlockStore: useContentBlockStore()
    };
  },
  methods: {
    change: function (evt) {
      this.contentBlockStore.setFields(this.fieldsList);
      console.log("FieldsList: ", this.fieldsList);
    }
  }
};
</script>
<style scoped></style>
