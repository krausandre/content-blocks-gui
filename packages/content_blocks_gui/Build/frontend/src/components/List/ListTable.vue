<template>
  <div class="list-table-container" :class="props.title">
    <h2>{{ tableHeader(props.title) }}</h2>
    <table class="cb-list-table">
      <thead>
      <tr>
        <th></th>
        <th>
          Name
        </th>
        <th>
          Label
        </th>
        <th>
          Extension
        </th>
        <th>Actions</th>
      </tr>
      </thead>
      <tr
          v-for="item in props.items"
          :key="item.name"
      >
        <td><Icon :identifier="getTypeOfRecord()" size="medium"/></td>
        <td> {{ item.name }}</td>
        <td> {{ item.label }}</td>
        <td> {{ item.extension }}</td>
        <td>
          <button
              type="button"
              class="btn btn-default"
              @click="edit(item.name)"
          >
            <Icon identifier="actions-open"/>
            Edit
          </button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script setup lang="ts">
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import Icon from "@/components/icons/Icon.vue";
import {useContentBlockStore} from "@/store/contentBlockStore";
import axios from "axios";

interface Item {
  name: string;
  label: string;
  extension: string;
}

const globalPropertiesStore = useGlobalPropertiesStore();
const contentBlockStore = useContentBlockStore();

const props = defineProps({
  title: String,
  items: Array<Item>
})

function getTypeOfRecord() {
  switch (props.title) {
    case 'RECORD_TYPE':
      return 'content-extension';
    case 'CONTENT_ELEMENT':
      return 'content-beside-text-img-below-right';
    case 'PAGE_TYPE':
      return 'mimetypes-text-typoscript';
  }
}

function tableHeader(title: any) {
  return title.replace('_', " ");
}

const edit = (name: string) => {
  globalPropertiesStore.setCurrentViewToEditView()
  globalPropertiesStore.setIsLoading(true)

  axios
      .postForm(
          TYPO3.settings.ajaxUrls.content_blocks_gui_get_cb,
          {
            name: name
          }
      )
      .then(
          (response) => {
            const nameParts = response.data.body.contentBlock.name.split('/')

            contentBlockStore.setVendor(nameParts[0])
            contentBlockStore.setPackage(nameParts[1])

            globalPropertiesStore.setIsLoading(false)
          }
      )
      .catch(
          (error) => {
            console.error('Error:', error);
            globalPropertiesStore.setIsLoading(false)
          }
      );

  // const data = new FormData()
  // data.set('name', name)
  //
  // fetch(
  //     TYPO3.settings.ajaxUrls.content_blocks_gui_get_cb,
  //     {
  //       method: 'POST',
  //       body: data,
  //     }
  // )
  //     .then(
  //         (response) => response.json()
  //     )
  //     .then(
  //         (data) => {
  //           console.log('Success:', data);
  //         }
  //     )
  //     .catch(
  //         (error) => {
  //           console.error('Error:', error);
  //         }
  //     );
}

</script>
