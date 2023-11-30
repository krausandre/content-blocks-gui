<template>
  <div class="d-flex flex-column" >
    <h1>Liste:</h1>
    <ListTable
      v-for="(table, name , index) in contentBlocksStore.getList"
      :title="getHeaderFromTable(index)"
      :key="table.key"
      :items="table"/>
  </div>
</template>


<script setup lang="ts">
import {useContentBlocksListStore} from '../store/contentBlocksListStore'
import ListTable from '@/components/List/ListTable.vue'
import Icon from '@/components/icons/Icon.vue'
import axios from "axios";

const contentBlocksStore = useContentBlocksListStore();

function getHeaderFromTable(index: number) {
  const headers = Object.keys(contentBlocksStore.getList);
  return headers[index];
}
contentBlocksStore.fetch();
</script>
