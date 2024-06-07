<template>
  <FormKit
    type="form"
    class="mb-3"
    :actions="false"
    @submit="console.log('test')"
  >
    <FormKit
      label="Extension"
      type="select"
      name="hostExtension"
      :classes="{label: 'form-label', input: 'form-control', outer: 'mb-3'}"
      v-model="contentBlockStore.contentBlock.hostExtension"
    >
      <option
        v-for="item in extensionListStore.list"
        :value="item.extension"
        :selected="item.extension === contentBlockStore.contentBlock.hostExtension"
      >
        {{ item.extension }} [{{ item.vendor }}/{{ item.package }}]
      </option>
    </FormKit>
    <FormKit
      label="Name"
      name="name"
      validation="required"
      :classes="{label: 'form-label', input: 'form-control', outer: 'mb-3'}"
      v-model="contentBlockStore.getContentBlock.name"
      help="The name of the content-block. Must contain a vendor and a name. <code>vendor/name</code>"
    />
    <FormKit
      label="Title"
      name="title"
      :classes="{label: 'form-label', input: 'form-control', outer: 'mb-3'}"
      v-model="contentBlockStore.getContentBlock.yaml.title"
      help="This is the title of the Content Block. This could contain any string with spaces."
    />
    <FormKit
      type="checkbox"
      label="Prefix fields?"
      name="prefixFields"
      :classes="{outer: 'form-check mb-3', label: 'form-check-label', input: 'form-check-input'}"
      v-model="contentBlockStore.getContentBlock.yaml.prefixFields"
    />
    <FormKit
      type="select"
      label="Prefix type"
      name="prefixType"
      :classes="{label: 'form-label', input: 'form-control', outer: 'mb-3'}"
      v-model="contentBlockStore.getContentBlock.yaml.prefixType"
      >
      <option
        v-for="item in PrefixTypes"
        :value="item"
        :selected="item === contentBlockStore.contentBlock.yaml.prefixType"
      >
        {{ item }}
      </option>
    </FormKit>
    <FormKit
      label="Vendor prefix"
      name="vendorPrefix"
      :classes="{label: 'form-label', input: 'form-control', outer: 'mb-3'}"
      v-model="contentBlockStore.getContentBlock.yaml.vendorPrefix"
      help="If set, this prefix will be used instead of the vendor part of <code>name</code>"
    />
    <FormKit
      label="Priority"
      name="priority"
      type="number"
      :classes="{label: 'form-label', input: 'form-control', outer: 'mb-3'}"
      v-model="contentBlockStore.getContentBlock.yaml.priority"
      help="The priority can be used to prioritize certain Content Blocks in the loading order. Higher priorities will be loaded before lower ones."
    />
    <FormKit
      label="Group"
      type="select"
      name="group"
      :classes="{label: 'form-label', input: 'form-control', outer: 'mb-3'}"
      v-model="contentBlockStore.getContentBlock.yaml.group"
      aria-describedby="group"
    >
      <option
        v-for="(item, key) in groupListStore.list"
        :value="key"
        :key="{ key }"
        :selected="key === contentBlockStore.contentBlock.yaml.group"
      >
        {{ item }} [{{ key }}]
      </option>
    </FormKit>
    <FormKit
      type="submit"
      label="Save"
      :classes="{input: 'btn btn-primary', outer: 'mb-3'}"
    />
  </FormKit>
  <div class="mb-3">
    <pre>
      {{ JSON.stringify(contentBlockStore.getContentBlock, null, 2) }}
    </pre>
    <pre>
      {{ JSON.stringify(contentBlockStore.getContentBlock.getFields, null, 2) }}
    </pre>
  </div>
</template>

<script setup>
import {ContentBlock, PrefixTypes} from "@/models/ContentBlock";
import {useContentBlockStore} from "@/store/contentBlockStore";
import {useExtensionListStore} from "@/store/extensionListStore";
import {useGroupListStore} from "@/store/groupListStore";
import {computed, watchEffect} from "vue";
import {FormKit} from "@formkit/vue";

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
