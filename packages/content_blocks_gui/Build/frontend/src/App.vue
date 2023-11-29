<template>
  <TheHeader />
  <ListView v-if="globalPropertiesStore.getCurrentView === 'c-b-list-view'"/>
  <EditView v-else />
</template>

<script setup lang="ts">
import {useContentBlockStore} from './store/contentBlockStore'
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";

import TheHeader from './components/TheHeader.vue';
import EditView from "@/views/EditView.vue";
import ListView from "@/views/ListView.vue";

const contentBlockStore = useContentBlockStore();
const globalPropertiesStore = useGlobalPropertiesStore();

</script>

<style scoped>
</style>
