<template>
  <div class="d-flex flex-column" >
    <h1>Liste:</h1>
    <h2>Content Elements</h2>
    <table class="cb-list-table">
      <thead>
        <tr>
          <th>

          </th>
          <th>
            Name
          </th>
          <th>
            Identifier
          </th>
          <th>
            Extension
          </th>
        </tr>
      </thead>
      <tr
          v-for="item in contentBlocksStore.getList.CONTENT_ELEMENT"
          :key="item.identifier"
      >
       <td><img src="../assets/icons/DefaultContentElementIcon.svg" alt=""></td>
       <td> {{item.name}} </td>
       <td> {{item.identifier}} </td>
       <td> {{item.extension}} </td>
      </tr>
    </table>
    <h2>Page Types</h2>
    <table class="cb-list-table">
      <thead>
        <tr>
          <th>
            
          </th>
          <th>
            Name
          </th>
          <th>
            Identifier
          </th>
          <th>
            Extension
          </th>
        </tr>
      </thead>
      <tr
          v-for="item in contentBlocksStore.getList.PAGE_TYPE"
          :key="item.identifier"
      >
       <td><img src="../assets/icons/DefaultPageTypeIcon.svg" alt=""></td>
       <td> {{item.name}} </td>
       <td> {{item.identifier}} </td>
       <td> {{item.extension}} </td>
      </tr>
    </table>
    <h2>Record Types</h2>
    <table class="cb-list-table">
      <thead>
        <tr>
          <th>
            
          </th>
          <th>
            Name
          </th>
          <th>
            Identifier
          </th>
          <th>
            Extension
          </th>
        </tr>
      </thead>
      <tr
          v-for="item in contentBlocksStore.getList.RECORD_TYPE"
          :key="item.identifier"
      >
       <td><img src="../assets/icons/DefaultRecordTypeIcon.svg" alt=""></td>
       <td> {{item.name}} </td>
       <td> {{item.identifier}} </td>
       <td> {{item.extension}} </td>
      </tr>
    </table>
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
