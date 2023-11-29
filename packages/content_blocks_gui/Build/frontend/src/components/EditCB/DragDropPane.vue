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
            :is="item.componentName"
            :identifier="item.identifier"
            :label="item.label + ' (' + item.identifier + ')'"
            :icon-identifier="item.iconIdentifier"/>
      </template>
    </draggable>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import BaseFieldType from "@/components/fieldTypes/BaseFieldType.vue";

import {useContentBlockStore} from "@/store/contentBlockStore";

export default {
  name: "clone",
  display: "Clone",
  order: 2,
  components: {
    BaseFieldType,
    draggable
  },
  data() {
    return {
      fieldsList: [

      ],
      contentBlockStore: useContentBlockStore()
    };
  },
  methods: {
    change: function(evt) {
      this.contentBlockStore.setFields(this.fieldsList);
      console.log("FieldsList: ", this.fieldsList);
    }
  }
};
</script>
<style scoped></style>
