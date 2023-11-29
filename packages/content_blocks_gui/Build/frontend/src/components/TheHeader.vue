<template>
  <nav>
    <div class="btn-group px-0 mb-2" role="group" aria-label="Main navigation">
      <button
          class="btn btn-secondary"
          @click="handleBackToOverview"
          v-if="globalPropertiesStore.getIsEditView"
          type="button"
      >
        <Icon identifier="actions-arrow-left"/>
        Back to overview
      </button>

      <button
          type="button"
          class="btn btn-primary"
          @click="contentBlockStore.resetContentBlock('tt_content'); globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      >
        <Icon identifier="actions-extension-add"/>
        Add content block
      </button>

      <button
          type="button"
          class="btn btn-primary"
          @click="contentBlockStore.resetContentBlock(''); globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      >
        <Icon identifier="actions-extension-add"/>
        Add record type
      </button>

      <button
          type="button"
          class="btn btn-primary"
          @click="contentBlockStore.resetContentBlock('pages'); globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      >
        <Icon identifier="actions-extension-add"/>
        Add page type
      </button>

      <button
          type="button"
          class="btn btn-primary"
          @click="contentBlockStore.resetContentBlock('@todo basic'); globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      >
        <Icon identifier="actions-extension-add"/>
        Add Basic
      </button>

      <button
          type="button"
          class="btn btn-primary"
          @click="controller.saveCb()"
          v-if="globalPropertiesStore.getIsEditView"
      >
        <Icon identifier="actions-save"/>
        Save
      </button>
    </div>
  </nav>
</template>

<script setup>
import controller from "@/Controller";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import {useContentBlockStore} from "@/store/contentBlockStore";
import Icon from "@/components/icons/Icon.vue";
import axios from "axios";

const globalPropertiesStore = useGlobalPropertiesStore();
const contentBlockStore = useContentBlockStore();

const getIcons = () => {
  axios.get(TYPO3.settings.ajaxUrls.list_icons).then((response) => {
    console.log(response.data)
  })
  .catch((error) => {
    console.log(error)
  });
}

const handleBackToOverview = () => {
  globalPropertiesStore.setCurrentViewToCbListView();
  globalPropertiesStore.setCurrentSelectedFieldIdentifier('');
}
</script>

<style scoped>

</style>
