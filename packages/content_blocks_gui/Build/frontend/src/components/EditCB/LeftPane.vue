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
import Tabs from '@/components/Tabs.vue'
import Tab from '@/components/Tab.vue'
</script>

<style scoped>
</style>
