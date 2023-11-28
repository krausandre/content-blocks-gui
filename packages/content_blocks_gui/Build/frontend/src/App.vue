<template>
  <TheHeader />
  <CBListView v-if="currentComponent === 'c-b-list-view'"/>
  <EditCbView v-else />
  <button @click="currentComponent = 'edit-cb-view'">Switch to Edit View</button>
  <button @click="currentComponent = 'c-b-list-view'">Back to overview</button>
</template>

<script setup lang="ts">
import {ref} from 'vue'
import {useContentBlockStore} from './store/contentBlockStore'

import TheHeader from './components/TheHeader.vue';
import EditCbView from './components/EditCbView.vue';
import CBListView from "@/views/CBListView.vue";

const currentComponent = ref('c-b-list-view')

const store = useContentBlockStore();

</script>

<style scoped>
</style>
