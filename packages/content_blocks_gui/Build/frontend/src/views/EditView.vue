<template>
  <div class="editview">
    <div class="row">
      <div class="col-4">
        <LeftPane/>
      </div>
      <div class="col-4">
        <DragDropPane/>
      </div>
      <div class="col-4">
        <PropertiesPane/>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import LeftPane from "@/components/EditCB/LeftPane.vue";
import DragDropPane from "@/components/EditCB/DragDropPane.vue";
import PropertiesPane from "@/components/EditCB/PropertiesPane.vue";
</script>
