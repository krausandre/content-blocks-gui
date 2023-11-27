<template>
  <h1>{{store.getName}}</h1>
</template>

<script setup lang="ts">
import {useContentBlockStore} from './store/contentBlockStore'

const store = useContentBlockStore();
</script>

<style scoped>
</style>
