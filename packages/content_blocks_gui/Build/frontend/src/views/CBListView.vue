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
import ListTable from './ListCB/ListTable.vue'
import axios from "axios";

const contentBlocksStore = useContentBlocksListStore();

const updateContentBlocksList = () => {
  // Get the list from the backend

  axios.get(TYPO3.settings.ajaxUrls.list_cb).then((response) => {
    console.log(response.data)
    contentBlocksStore.setList(response.data.list)
  })
      .catch((error) => {
        console.log(error)
      });
}

function getHeaderFromTable(index: number) {
  const headers = Object.keys(contentBlocksStore.getList);
  return headers[index].replace('_', " ");
}
updateContentBlocksList()
</script>
