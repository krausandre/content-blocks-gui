<template>
  <TheHeader />
  <ListView v-if="globalPropertiesStore.getCurrentView === AppMainView.LIST_VIEW"/>
  <EditView v-else />
</template>

<script setup lang="ts">
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";

import TheHeader from './components/TheHeader.vue';
import EditView from "@/views/EditView.vue";
import ListView from "@/views/ListView.vue";
import {AppMainView} from "@/Controller";

const globalPropertiesStore = useGlobalPropertiesStore();

</script>

<style scoped>
</style>
