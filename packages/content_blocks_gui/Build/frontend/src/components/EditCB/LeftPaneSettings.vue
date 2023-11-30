<template>
  <form>
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input class="form-control" id="vendor" aria-describedby="name"
             :value="contentBlockStore.getContentBlock.name"
      >
    </div>
    <div class="mb-3" v-if="ContentBlock.isContentElement(contentBlockStore.contentBlock) /* @todo */">
      <label for="group" class="form-label">Group</label>
      <select class="form-control" id="group" aria-describedby="group">
        <option v-for="(item, key) in groupListStore.list"
                value="{{ key }}"
        >
          {{ item }} [{{ key }}]
        </option>
      </select>
    </div>
    <div class="mb-3">
      <label for="group" class="form-label">Extension</label>
      <select class="form-control" id="group" aria-describedby="group">
        <option v-for="item in extensionListStore.list"
                :value="item.extension"
                :selected="item.extension === contentBlockStore.contentBlock.hostExtension"
        >
          {{ item.extension }} [{{ item.vendor }}/{{ item.package }}]
        </option>
      </select>
    </div>
    <div class="mb-3">
      <label for="table" class="form-label">Table</label>
      <input class="form-control" id="table" aria-describedby="table"
             :value="contentBlockStore.getContentBlock.yaml.table"
      >
    </div>
  </form>
</template>

<script setup>
import {ContentBlock} from "@/models/ContentBlock";
import {useContentBlockStore} from "@/store/contentBlockStore";
import {useExtensionListStore} from "@/store/extensionListStore";
import {useGroupListStore} from "@/store/groupListStore";

const contentBlockStore = useContentBlockStore();
const extensionListStore = useExtensionListStore();
const groupListStore = useGroupListStore();

extensionListStore.fetch()
groupListStore.fetch()
</script>

<style scoped>
</style>
