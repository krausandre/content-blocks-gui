<template>
  <EditCbView v-if="currentComponent === 'edit-cb-view'"/>
</template>

<script setup lang="ts">
import {ref} from 'vue'
import {useContentBlockStore} from './store/contentBlockStore'

import EditCbView from './components/EditCbView.vue';

const currentComponent = ref('edit-cb-view')

const store = useContentBlockStore();


</script>

<style scoped>
</style>
