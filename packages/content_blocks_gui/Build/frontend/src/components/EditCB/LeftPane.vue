<template>
  <Tabs>
    <Tab active="true" title="Settings">
      <LeftPaneSettings/>
    </Tab>
    <Tab title="Components">
      <LeftPaneComponents/>
    </Tab>
    <Tab title="Basics">
      @todo basics
    </Tab>
  </Tabs>

</template>

<script setup>
import LeftPaneComponents from "@/components/EditCB/LeftPaneComponents.vue";
import LeftPaneSettings from "@/components/EditCB/LeftPaneSettings.vue";
import {useContentBlockStore} from "@/store/contentBlockStore";
import Tabs from '@/components/Tabs.vue'
import Tab from '@/components/Tab.vue'

let idGlobal = 0;

const contentBlockStore = useContentBlockStore();

const cloneFieldType = (item) => {
  console.log(item);
  return {
    identifier: item.identifier + "_" + idGlobal++,
    componentName: item.componentName,
    label: item.label,
    iconIdentifier: item.iconIdentifier,
    properties: item.properties
  };
}
</script>

<style scoped>
</style>
