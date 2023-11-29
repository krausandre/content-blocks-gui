<template>
  <div class="">
    <div class="">
      <draggable
        class="dragArea list-group"
        :list="fieldsList"
        group="people"
        @change="log"
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

    <rawDisplayer class="col-3" :value="fieldsList" title="List 2" />
  </div>
</template>

<script>
import draggable from "vuedraggable";
import BaseFieldType from "@/components/fieldTypes/BaseFieldType.vue";
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

      ]
    };
  },
  methods: {
    log: function(evt) {
      console.log("FieldsList: ", this.fieldsList);
    }
  }
};
</script>
<style scoped></style>
