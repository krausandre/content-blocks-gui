<template>
  <EditCbView v-if="currentComponent === 'edit-cb-view'"/>
  <CBListView />
</template>

<script setup lang="ts">
import {ref} from 'vue'
import {useContentBlockStore} from './store/contentBlockStore'

import EditCbView from './components/EditCbView.vue';
import CBListView from "@/views/CBListView.vue";

const currentComponent = ref('edit-cb-view')

const store = useContentBlockStore();


</script>

<style scoped>
</style>
