<template>
  <div class="spinner"
       :class="{
          'spinner--active': useGlobalPropertiesStore().isLoading
       }"
  >
    @todo
    Loading spinner
  </div>

  <TheHeader />
  <ListView v-if="globalPropertiesStore.getCurrentView === AppMainView.LIST_VIEW" />
  <EditView v-else />
</template>

<script setup lang="ts">
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";

import TheHeader from '@/components/TheHeader.vue';
import EditView from "@/views/EditView.vue";
import ListView from "@/views/ListView.vue";
import {AppMainView} from "@/Controller";

const globalPropertiesStore = useGlobalPropertiesStore();

</script>

<style scoped>
.spinner {
  opacity: 0;
  position: absolute;
  z-index: -1;
  inset: 0;
  transition: opacity .3s ease-in-out;
}

.spinner--active {
  z-index: 1;
  opacity: 1;
  background: greenyellow;
}
</style>
