<script setup lang="ts">
import Tabs from '../../components/Tabs.vue'
import Tab from '../../components/Tab.vue'
</script>

<template>
  <h1>Picker</h1>

  <Tabs>
    <Tab active="true" title="Settings">
      <form>
        <div class="mb-3">
          <label for="xxx" class="form-label">Identifier</label>
          <input class="form-control" id="xxx" aria-describedby="xxx">
        </div>
        <div class="mb-3">
          <label for="xxx" class="form-label">Vendor</label>
          <input class="form-control" id="xxx" aria-describedby="xxx">
        </div>
        <div class="mb-3">
          <label for="xxx" class="form-label">Group</label>
          Group Picker
          <input class="form-control" id="xxx" aria-describedby="xxx">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </Tab>
    <Tab title="Components">
      @todo components
    </Tab>
    <Tab title="Basics">
      @todo basics
    </Tab>
  </Tabs>

</template>

<style scoped>
</style>
