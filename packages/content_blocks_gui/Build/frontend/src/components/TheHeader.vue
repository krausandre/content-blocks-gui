<template>
  <nav>
    <div class="btn-group px-0 mb-2" role="group" aria-label="Main navigation">
      <button
          class="btn btn-secondary"
          @click="globalPropertiesStore.setCurrentViewToCbListView"
          v-if="globalPropertiesStore.getIsEditView"
          type="button"
      ><IconComponent identifier="actions-arrow-left" /> Back to overview</button>
      <button
          type="button"
          class="btn btn-primary"
          @click="globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      ><IconComponent identifier="actions-extension-add" /> Add content block
      </button>
      <button
          type="button"
          class="btn btn-primary"
          @click="globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      ><IconComponent identifier="actions-extension-add" />Add record type
      </button>
      <button
          type="button"
          class="btn btn-primary"
          @click="globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      ><IconComponent identifier="actions-extension-add" /> Add page type
      </button>
    </div>
  </nav>
</template>

<script setup>
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import IconComponent from "@/components/icons/IconComponent.vue";

const globalPropertiesStore = useGlobalPropertiesStore();

</script>

<style scoped>

</style>
