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
            disabled
        >
          <Icon identifier="actions-extension-add"/>
          Add record type
        </button>

        <button
            type="button"
            class="btn btn-primary"
            @click="handleAddPageType"
            v-if="globalPropertiesStore.getIsCbListView"
            disabled
        >
          <Icon identifier="actions-extension-add"/>
          Add page type
        </button>

        <button
            type="button"
            class="btn btn-primary"
            @click="handleAddBasic"
            v-if="globalPropertiesStore.getIsCbListView"
            disabled
        >
          <Icon identifier="actions-extension-add"/>
          Add Basic
        </button>
      </div>
    </nav>
    <div v-if="globalPropertiesStore.getIsEditView" class="alert alert-primary" role="alert">
      You are {{ contentBlockStore.mode === AppEditMode.EDIT ? 'editing' : 'creating' }}
      a {{ ContentBlock.typeString(contentBlockStore.contentBlock) }}
    </div>
    <div v-if="contentBlockStore.contentBlock.initialVendor" class="alert alert-primary" role="alert">
      (Copying from {{ contentBlockStore.contentBlock.initialVendor }}/{{ contentBlockStore.contentBlock.initialName }}
      in extension {{ contentBlockStore.contentBlock.hostExtension }})
    </div>

    <div class="btn-group px-0 mb-2" role="group" aria-label="Main navigation">
      <button
            type="button"
            class="btn btn-secondary btn-sm"
            @click="console.log(contentBlocksListStore.getList)"
        >
          Get Blocks List
        </button>
        <button class="btn btn-secondary btn-sm" id="ajaxTestBtn">AJAX Test-Button</button>
    </div>
  </div>
</template>

<script setup>
import controller, {AppEditMode} from "@/Controller";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import {useContentBlockStore} from "@/store/contentBlockStore";
import {useContentBlocksListStore} from "@/store/contentBlocksListStore";
import Icon from "@/components/icons/Icon.vue";
import {ContentBlock} from "@/models/ContentBlock";

const globalPropertiesStore = useGlobalPropertiesStore();
const contentBlockStore = useContentBlockStore();
const contentBlocksListStore = useContentBlocksListStore();

const handleBackToOverview = () => {
  contentBlockStore.resetContentBlock()
  globalPropertiesStore.setCurrentViewToCbListView();
  globalPropertiesStore.setCurrentSelectedFieldIdentifier('');
}

const handleSaveContentBlock = () => {
  controller.saveCb();
}

const handleAddContentBlock = () => {
  contentBlockStore.resetContentBlock();
  globalPropertiesStore.setCurrentViewToEditView();
  ContentBlock.setTypeContentElement(contentBlockStore.contentBlock);
}

const handleAddRecordType = () => {
  contentBlockStore.resetContentBlock();
  globalPropertiesStore.setCurrentViewToEditView();
  ContentBlock.setTypeRecordType(contentBlockStore.contentBlock);
}

const handleAddPageType = () => {
  contentBlockStore.resetContentBlock();
  globalPropertiesStore.setCurrentViewToEditView();
  ContentBlock.setTypePagetype(contentBlockStore.contentBlock);
}

const handleAddBasic = () => {
  contentBlockStore.resetContentBlock();
  globalPropertiesStore.setCurrentViewToEditView();
  ContentBlock.setTypeBasic(contentBlockStore.contentBlock);
}
</script>
