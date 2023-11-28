<template>
  <div class="">
    <div class="">
      <h3>Draggable 1</h3>
      <draggable
        class="dragArea list-group"
        :list="list1"
        :group="{ name: 'people', pull: 'clone', put: false }"
        @change="log"
      >
        <template #item="{ element: item }">
          <li>
            {{ item.name }}
          </li>
        </template>
      </draggable>
    </div>

    <div class="">
      <h3>Draggable 2</h3>
      <draggable
        class="dragArea list-group"
        :list="list2"
        group="people"
        @change="log"
      >
        <template #item="{ element: item }">
          <li>
            {{ item.name }}
          </li>
        </template>
      </draggable>
    </div>

    <rawDisplayer class="col-3" :value="list1" title="List 1" />

    <rawDisplayer class="col-3" :value="list2" title="List 2" />
  </div>
</template>

<script>
import draggable from "vuedraggable";
export default {
  name: "clone",
  display: "Clone",
  order: 2,
  components: {
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