<template>
  <nav>
    <div class="btn-group px-0 mb-2" role="group" aria-label="Main navigation">
      <button
          class="btn btn-secondary"
          @click="globalPropertiesStore.setCurrentViewToCbListView"
          v-if="globalPropertiesStore.getIsEditView"
          type="button"
      ><BackIconComponent /> Back to overview</button>
      <button
          type="button"
          class="btn btn-primary"
          @click="globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      ><PlusIconComponent /> Add content block
      </button>
      <button
          type="button"
          class="btn btn-primary"
          @click="globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      ><PlusIconComponent />Add record type
      </button>
      <button
          type="button"
          class="btn btn-primary"
          @click="globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      ><PlusIconComponent /> Add page type
      </button>
    </div>
  </nav>
</template>

<script setup>
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import BackIconComponent from "@/components/icons/BackIconComponent.vue";
import PlusIconComponent from "@/components/icons/PlusIconComponent.vue";

const globalPropertiesStore = useGlobalPropertiesStore();

</script>

<style scoped>

</style>
