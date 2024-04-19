<template>
  <form>
    <div class="mb-3">
      <label for="hostExtension" class="form-label">Extension</label>
      <select
        class="form-control"
        id="hostExtension"
        aria-describedby="hostExtension"
        v-model="contentBlockStore.contentBlock.hostExtension"
      >
        <option
          v-for="item in extensionListStore.list"
          :value="item.extension"
          :selected="item.extension === contentBlockStore.contentBlock.hostExtension"
        >
          {{ item.extension }} [{{ item.vendor }}/{{ item.package }}]
        </option>
      </select>
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input class="form-control" id="name" aria-describedby="name"
        v-model="contentBlockStore.getContentBlock.name"
      >
      <div id="nameHelp" class="form-text">The name of the content-block. Must contain a vendor and a name. <code>vendor/name</code></div>
    </div>
    <div class="mb-3">
      <label for="title" class="form-label">Title</label>
      <input class="form-control" id="title" aria-describedby="title" v-model="contentBlockStore.getContentBlock.yaml.title"
      >
      <div id="titleHelp" class="form-text">This is the title of the Content Block. This could contain any string with spaces.</div>
    </div>
    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" v-model="contentBlockStore.getContentBlock.yaml.prefixFields" id="prefixFields">
      <label class="form-check-label" for="prefixFields">
        Prefix fields?
      </label>
    </div>
    <div class="mb-3">
      <label class="form-label" for="prefixType">Prefix typeasdasdds</label>
      <select
        class="form-control"
        id="prefixType"
        v-model="contentBlockStore.contentBlock.yaml.prefixType"
        aria-describedby="prefixType">
        <option
          v-for="item in PrefixTypes"
          :value="item"
          :selected="item === contentBlockStore.contentBlock.yaml.prefixType"
        >
          {{ item }}
        </option>
      </select>
    </div>
    <div class="mb-3">
      <label for="vendorPrefix" class="form-label">Vendor prefix</label>
      <input class="form-control" id="vendorPrefix" aria-describedby="vendor-prefix"
             v-model="contentBlockStore.getContentBlock.yaml.vendorPrefix"
      >
      <div id="titleHelp" class="form-text">If set, this prefix will be used instead of the vendor part of <code>name</code></div>
    </div>
    <div class="mb-3">
      <label for="priority" class="form-label">Priority</label>
      <input class="form-control" id="priority" aria-describedby="priority" type="number"
             v-model="contentBlockStore.getContentBlock.yaml.priority"
      >
      <div id="priorityHelp" class="form-text">The priority can be used to prioritize certain Content Blocks in the loading order. Higher priorities will be loaded before lower ones.</div>
    </div>
    <div class="mb-3" v-if="ContentBlock.isContentElement(contentBlockStore.contentBlock) /* @todo */">
      <label for="group" class="form-label">Group -> nur für content elements</label>
      <select
        class="form-control"
        id="group"
        v-model="contentBlockStore.contentBlock.yaml.group"
        aria-describedby="group">
        <option
          v-for="(item, key) in groupListStore.list"
          :value="key"
          :key="{ key }"
          :selected="key === contentBlockStore.contentBlock.yaml.group"
        >
          {{ item }} [{{ key }}]
        </option>
      </select>
    </div>
    <div class="mb-3">
      fields -> werden über Drag and Drop befüllt
    </div>
    <div class="mb-3">
      <pre>
        {{ JSON.stringify(contentBlockStore.getContentBlock, null, 2) }}
      </pre>
      <pre>
        {{ JSON.stringify(contentBlockStore.getContentBlock.getFields, null, 2) }}
      </pre>
    </div>
<!--    Is no root element
<div class="mb-3">
      <label for="table" class="form-label">Table</label>
      <input class="form-control" id="table" aria-describedby="table"
             :value="contentBlockStore.getContentBlock.yaml.table"
      >
    </div>-->
  </form>
</template>

<script setup>
import {ContentBlock, PrefixTypes} from "@/models/ContentBlock";
import {useContentBlockStore} from "@/store/contentBlockStore";
import {useExtensionListStore} from "@/store/extensionListStore";
import {useGroupListStore} from "@/store/groupListStore";
import {computed, watchEffect} from "vue";

const contentBlockStore = useContentBlockStore();
const extensionListStore = useExtensionListStore();
const groupListStore = useGroupListStore();

extensionListStore.fetch()
groupListStore.fetch()

const nameModel = computed({
  get: () => contentBlockStore.getContentBlock.name,
  set: (value) => contentBlockStore.setFieldValue('name', 'name', value)
});

watchEffect(() => {
  console.log('contentBlockStore.getContentBlock', contentBlockStore.getContentBlock)
})
</script>

<style scoped>
</style>
