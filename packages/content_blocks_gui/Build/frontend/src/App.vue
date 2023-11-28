<template>
  <TheHeader />
  <CBListView v-if="globalPropertiesStore.getCurrentView === 'c-b-list-view'"/>
  <EditCbView v-else />
</template>

<script setup lang="ts">
import {useContentBlockStore} from './store/contentBlockStore'
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";

import TheHeader from './components/TheHeader.vue';
import EditCbView from './components/EditCbView.vue';
import CBListView from "@/views/CBListView.vue";

const contentBlockStore = useContentBlockStore();
const globalPropertiesStore = useGlobalPropertiesStore();

</script>

<style scoped>
</style>
