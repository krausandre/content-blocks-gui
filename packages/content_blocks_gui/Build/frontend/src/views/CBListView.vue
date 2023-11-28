<template>
  <div class="d-flex flex-column" >
    <h1>Liste:</h1>
    <hr>
    <span>Content Elements</span>
    <ul>
      <li
          v-for="item in contentBlocksStore.getList.CONTENT_ELEMENT"
          :key="item.identifier"
      >
        {{item.identifier}}
      </li>
    </ul>

    <hr>
    <span>Page Types</span>
    <ul>
      <li
          v-for="item in contentBlocksStore.getList.PAGE_TYPE"
          :key="item.identifier"
      >
        {{item.identifier}}
      </li>
    </ul>
    <hr>
    <span>Record Types</span>
    <ul>
      <li
          v-for="item in contentBlocksStore.getList.RECORD_TYPE"
          :key="item.identifier"
      >
        {{item.identifier}}
      </li>
    </ul>
  </div>
</template>


<script setup lang="ts">
import {useContentBlocksListStore} from '../store/contentBlocksListStore'
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

updateContentBlocksList()
</script>
