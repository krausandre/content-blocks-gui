<template>
  <div class="list-table-container" :class="props.title">
    <h2>{{ tableHeader(props.title) }}</h2>
    <table class="cb-list-table">
      <thead>
      <tr>
        <th></th>
        <th>Name</th>
        <th>Label</th>
        <th>Extension</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tr
          v-for="item in props.items"
          :key="item.name"
      >
        <td>
          <Icon :identifier="getTypeOfRecord()" size="medium"/>
        </td>
        <td>{{ item.name }}</td>
        <td>{{ item.label }}</td>
        <td>{{ item.extension }}</td>
        <td>
          <button
              type="button"
              class="btn btn-default"
              @click="edit(item.name)"
          >
            <Icon identifier="actions-open"/>
            Edit
          </button>
          <button
              type="button"
              class="btn btn-info ms-2"
              @click="download(item.name)"
          >
            <Icon identifier="actions-download"/>
            Download</button>
          <button
              type="button"
              class="btn btn-danger ms-2"
              @click="shootDangerModal('Delete content block', 'Do you really want to delete this content block?')"
          >
            <Icon identifier="actions-delete"/>
            Delete</button>
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

import {shootSuccessNotification, shootInfoNotification, shootErrorNotification, shootNoticeNotification, shootWarningNotification} from "../../helper/typo3NotificationHelper.js"
import {shootDangerModal} from "@/helper/typo3ModalHelper";

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
            globalPropertiesStore.setIsLoading(false)
            contentBlockStore.setContentBlock(response.data.body.contentBlock)
          }
      )
      .catch(
          (error) => {
            console.error('Error:', error);
            globalPropertiesStore.setIsLoading(false)
          }
      );
}

const download = (name: string) => {
  axios
      .postForm(
          TYPO3.settings.ajaxUrls.content_blocks_gui_download_cb,
          {
            name: name
          },
          {
            responseType: 'blob',
          }
      )
      .then(response => {
        // Notification von TYPO3 anzeigen -> Download läuft
        shootInfoNotification("Download started", "The download has started. This might take a while.");
        const contentDisposition = response.headers['content-disposition'];
        let filename = name + '.zip';
        if (contentDisposition) {
          const filenameMatch = contentDisposition.match(/filename="?([^"]+)"?/);
          if (filenameMatch && filenameMatch.length > 1) {
            filename = filenameMatch[1];
          }
        }

        // Entferne mögliche Anführungszeichen am Ende des Dateinamens
        filename = filename.replace(/"+$/, '');

        // Erstelle eine URL für den Blob und triggere den Download
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', filename); // Setze den ursprünglichen Dateinamen

        document.body.appendChild(link);
        link.click();

        window.URL.revokeObjectURL(url); // Bereinigung
        // Notification von TYPO3 anzeigen -> Download fertig
        shootSuccessNotification("Download finished", "The download has finished.");
      })
      .catch(
          (error) => {
            console.error('Error:', error);
            // Notification Error von TYPO3 anzeigen
          }
      );
}

</script>
