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
        <th>Usages</th>
        <th>Actions</th>
      </tr>
      </thead>
      <tr
          v-for="item in props.items"
          :key="item.name"
      >
        <td>
          <Icon :identifier="iconListStore.getIconByIdentifier(item.name)" size="medium"/>
        </td>
        <td>{{ item.name }}</td>
        <td>{{ item.label }}</td>
        <td>{{ item.extension }}</td>
        <td>{{ item.usages }}</td>
        <td>
          <button
              type="button"
              class="btn btn-default me-2"
              @click="edit(item.name)"
              v-if="item.editable"
          >
            <Icon identifier="actions-open"/>
            Edit
          </button>
          <button
              type="button"
              class="btn btn-info me-2"
              @click="download(item.name)"
          >
            <Icon identifier="actions-download"/>
            Download
          </button>
          <button
              type="button"
              class="btn btn-danger me-2"
              @click="showDeleteConfirmation(item.name)"
              v-if="item.deletable && item.usages < 1"
          >
            <Icon identifier="actions-delete"/>
            Delete
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
import {useContentBlocksListStore} from "@/store/contentBlocksListStore";
import {useIconListStore} from "@/store/iconListStore";
import axios from "axios";

import {
  shootErrorNotification,
  shootInfoNotification,
  shootSuccessNotification
} from "@/helper/typo3NotificationHelper.js"
import {shootDangerModal} from "@/helper/typo3ModalHelper";
import {AppEditMode} from "@/Controller";

interface Item {
  name: string;
  label: string;
  extension: string;
  usages: number;
  deletable: boolean;
  editable: boolean;
}

const globalPropertiesStore = useGlobalPropertiesStore();
const contentBlocksListStore = useContentBlocksListStore();
const contentBlockStore = useContentBlockStore();
const iconListStore = useIconListStore();

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
    case 'BASICS':
      return 'actions-document-open';
  }
}

function tableHeader(title: any) {
  return title.replace('_', " ");
}

const edit = (name: string) => {
  globalPropertiesStore.setIsLoading(true)
  axios.postForm(
      TYPO3.settings.ajaxUrls.content_blocks_gui_get_cb,
      {
        name: name
      }
  ).then(
      response => {
        globalPropertiesStore.setIsLoading(false)
        contentBlockStore.setContentBlock(response.data.body.contentBlock)
        contentBlockStore.setMode(AppEditMode.EDIT)
        globalPropertiesStore.setCurrentViewToEditView()
      }
  ).catch(
      error => {
        console.error('Error:', error);
        globalPropertiesStore.setIsLoading(false)
      }
  );
}

const download = (name: string) => {
  axios.postForm(
      TYPO3.settings.ajaxUrls.content_blocks_gui_download_cb,
      {
        name: name
      },
      {
        responseType: 'blob',
      }
  ).then(
      response => {
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
      }
  ).catch(
      error => {
        console.error('Error:', error);
        // Notification Error von TYPO3 anzeigen
      }
  );
}

const showDeleteConfirmation = (name: string) => {
  const deleteContentBlock = () => {
    deleteContentBlockByName(name);
  }

  shootDangerModal(
      "Delete content block",
      "Do you really want to delete this content block?",
      deleteContentBlock
  )
}

const deleteContentBlockByName = (name: string) => {
  axios.postForm(
      TYPO3.settings.ajaxUrls.content_blocks_gui_delete_cb,
      {
        name: name
      }
  ).then(
      (response) => {
        shootSuccessNotification("Content block deleted", "The content block was deleted.");
        contentBlocksListStore.fetch();
      }
  ).catch(
      (error) => {
        // Notification Error von TYPO3 anzeigen
        shootErrorNotification("Error", "The content block could not be deleted.");
        contentBlocksListStore.fetch();
      }
  );
}

</script>
