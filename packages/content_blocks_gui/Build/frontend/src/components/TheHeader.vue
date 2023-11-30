<template>
  <div class="d-flex justify-content-between">
    <nav>
      <button
          class="btn btn-info me-4"
          @click="handleBackToOverview"
          v-if="globalPropertiesStore.getIsEditView"
          type="button"
      >
        <Icon identifier="actions-arrow-left"/>
        Back to overview
      </button>

      <button
          type="button"
          class="btn btn-success"
          @click="handleSaveContentBlock"
          v-if="globalPropertiesStore.getIsEditView"
      >
        <Icon identifier="actions-save"/>
        Save
      </button>

      <div class="btn-group px-0 mb-2" role="group" aria-label="Main navigation">
        <button
            type="button"
            class="btn btn-primary"
            @click="handleAddContentBlock"
            v-if="globalPropertiesStore.getIsCbListView"
        >
          <Icon identifier="actions-extension-add"/>
          Add content block
        </button>

        <button
            type="button"
            class="btn btn-primary"
            @click="handleAddRecordType"
            v-if="globalPropertiesStore.getIsCbListView"
        >
          <Icon identifier="actions-extension-add"/>
          Add record type
        </button>

        <button
            type="button"
            class="btn btn-primary"
            @click="handle"
            v-if="globalPropertiesStore.getIsCbListView"
        >
          <Icon identifier="actions-extension-add"/>
          Add page type
        </button>

        <button
            type="button"
            class="btn btn-primary"
            @click="contentBlockStore.resetContentBlock('@todo basic'); globalPropertiesStore.setCurrentViewToEditView(); globalPropertiesStore.setCurrentContentType('basic');"
            v-if="globalPropertiesStore.getIsCbListView"
        >
          <Icon identifier="actions-extension-add"/>
          Add Basic
        </button>
      </div>
    </nav>
    <div>
      <div v-if="globalPropertiesStore.getIsEditView" class="alert alert-primary" role="alert">
        You are editing a {{ globalPropertiesStore.getCurrentContentType }}
      </div>
    </div>
    <div>
      <button
          type="button"
          class="btn btn-primary"
          @click="console.log(contentBlocksListStore.getList)"
      >
        Get Blocks List
      </button>
    </div>
  </div>
</template>

<script setup>
import controller from "@/Controller";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import {useContentBlockStore} from "@/store/contentBlockStore";
import {useContentBlocksListStore} from "@/store/contentBlocksListStore";
import {useIconListStore} from "@/store/iconListStore";
import Icon from "@/components/icons/Icon.vue";
import axios from "axios";
import {shootConfirmModal, shootDangerModal, shootPrimaryModal, shootWarningModal } from "../helper/typo3ModalHelper.js"
import {shootInfoNotification} from "@/helper/typo3NotificationHelper.js";

const globalPropertiesStore = useGlobalPropertiesStore();
const iconListStore = useIconListStore();
const contentBlockStore = useContentBlockStore();
const contentBlocksListStore = useContentBlocksListStore();

const handleBackToOverview = () => {
  globalPropertiesStore.setCurrentViewToCbListView();
  globalPropertiesStore.setCurrentSelectedFieldIdentifier('');
  globalPropertiesStore.setCurrentContentType('');
}

const handleSaveContentBlock = () => {
  shootInfoNotification("Saving content block", "This is not working at the moment. Please be patient with our wunderful developers", 10);
  // controller.saveCb();
}

const handleAddContentBlock = () => {
  contentBlockStore.resetContentBlock('tt_content');
  globalPropertiesStore.setCurrentViewToEditView();
  globalPropertiesStore.setCurrentContentType('content-block');
}

const handleAddRecordType = () => {
  contentBlockStore.resetContentBlock('');
  globalPropertiesStore.setCurrentViewToEditView();
  globalPropertiesStore.setCurrentContentType('record-type');
}

const handleAddPageType = () => {
  contentBlockStore.resetContentBlock('pages');
  globalPropertiesStore.setCurrentViewToEditView();
  globalPropertiesStore.setCurrentContentType('page-type');
}

const handleAddBasic = () => {
  contentBlockStore.resetContentBlock('@todo basic');
  globalPropertiesStore.setCurrentViewToEditView();
  globalPropertiesStore.setCurrentContentType('basic');
}
</script>

<style scoped>

</style>
