<template>
  <div class="">
    <div class="">
      <draggable
        class="dragArea list-group"
        :list="list2"
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

    <rawDisplayer class="col-3" :value="list2" title="List 2" />
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
      list1: [
        { name: "Fil", id: 1 },
        { name: "Andre", id: 2 },
        { name: "Manu", id: 3 },
        { name: "Philipp", id: 4 },
        { name: "Jonas", id: 5 }
      ],
      list2: [

      ]
    };
  },
  methods: {
    log: function(evt) {
      console.log(this.list1);
      console.log(this.list2);
    }
  }
};
</script>
<style scoped></style>
