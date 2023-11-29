<template>
  <nav>
    <div class="btn-group px-0 mb-2" role="group" aria-label="Main navigation">
      <button
          class="btn btn-secondary"
          @click="globalPropertiesStore.setCurrentViewToCbListView"
          v-if="globalPropertiesStore.getIsEditView"
          type="button"
      >
        <Icon identifier="actions-arrow-left"/>
        Back to overview
      </button>

      <button
          type="button"
          class="btn btn-primary"
          @click="globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      >
        <Icon identifier="actions-extension-add"/>
        Add content block
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

      <button
          type="button"
          class="btn btn-primary"
          @click="globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      >
        <Icon identifier="actions-extension-add"/>
        Add record type
      </button>

      <button
          type="button"
          class="btn btn-primary"
          @click="globalPropertiesStore.setCurrentViewToEditView()"
          v-if="globalPropertiesStore.getIsCbListView"
      >
        <Icon identifier="actions-extension-add"/>
        Add page type
      </button>
      <button
          type="button"
          class="btn btn-primary"
          @click="getIcons"
      ><Icon identifier="actions-extension-add" /> GetIconsAsList
      </button>
    </div>
  </nav>
</template>

<script setup>
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import Icon from "@/components/icons/Icon.vue";
import axios from "axios";

const globalPropertiesStore = useGlobalPropertiesStore();

const getIcons = () => {
  axios.get(TYPO3.settings.ajaxUrls.list_icons).then((response) => {
    console.log(response.data)
  })
  .catch((error) => {
    console.log(error)
  });
}
</script>

<style scoped>

</style>
