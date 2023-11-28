<template>
  <div class="alert alert-warning"
       v-if="useGlobalPropertiesStore().isLoading"
  >
    Bin Laden...
  </div>

  <div class="container">
    <div class="row">
      <div class="col-4">
        <PickerView/>
      </div>
      <div class="col-4">
        <DragDropView/>
      </div>
      <div class="col-4">
        <PropertiesView/>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import PickerView from "@/views/EditCB/PickerView.vue";
import DragDropView from "@/views/EditCB/DragDropView.vue";
import PropertiesView from "@/views/EditCB/PropertiesView.vue";
</script>
