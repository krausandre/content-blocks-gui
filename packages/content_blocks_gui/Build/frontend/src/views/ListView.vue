<template>
  <div class="d-flex flex-column" >
    <ListTable
      v-for="(table, name , index) in contentBlocksStore.getList"
      :title="getHeaderFromTable(index)"
      :key="table.key"
      :items="table"/>
  </div>
</template>


<script setup lang="ts">
import {useContentBlocksListStore} from '@/store/contentBlocksListStore'
import ListTable from '@/components/List/ListTable.vue'
import {useIconListStore} from "@/store/iconListStore";

const contentBlocksStore = useContentBlocksListStore();
const iconListStore = useIconListStore();

function getHeaderFromTable(index: number) {
  const headers = Object.keys(contentBlocksStore.getList);
  return headers[index];
}

contentBlocksStore.fetch();
iconListStore.fetch();
</script>
