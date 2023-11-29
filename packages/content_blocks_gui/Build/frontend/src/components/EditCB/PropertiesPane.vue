<template>
  <Tabs>
    <Tab active="true" title="Global">
      <div class="d-flex flex-column">
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="required" aria-describedby="required">
          <label for="required" class="form-check-label">Required</label>
        </div>
        <div class="mb-3">
          <label for="defaultValue" class="form-label">Default value</label>
          <input type="text" class="form-control" id="defaultValue" aria-describedby="defaultValue">
          <div id="defaultValueHelp" class="form-text">Default value set if a new record is created.</div>
        </div>
        <div class="mb-3">
          <label for="minLength" class="form-label">Min length</label>
          <input type="number" class="form-control" id="minLength" aria-describedby="minLength">
        </div>
        <div class="mb-3">
          <label for="maxLength" class="form-label">Max length</label>
          <input type="number" class="form-control" id="maxLength" aria-describedby="maxLength">
        </div>
        <div class="mb-3">
          <label for="size" class="form-label">Size</label>
          <input type="number" class="form-control" id="size" aria-describedby="size">
          <div id="sizeHelp" class="form-text">Abstract value for the width of the &lt;input&gt; field.</div>
        </div>
        <div class="mb-3">
          <label for="placeholder" class="form-label">Placeholder</label>
          <input type="text" class="form-control" id="placeholder" aria-describedby="placeholder">
          <div id="placeholderHelp" class="form-text">Placeholder text for the field.</div>
        </div>
        <div class="mb-3">
          <label for="valuePicker" class="form-label">Value picker</label>
          <input type="text" class="form-control" id="valuePicker" aria-describedby="valuePicker">
        </div>
        <pre>
          {{ contentBlockStore.getFields }}
        </pre>
      </div>
    </Tab>
    <Tab title="Validation" />
  </Tabs>
</template>

<script setup lang="ts">
import Tab from "@/components/Tab.vue";
import Tabs from "@/components/Tabs.vue";

import { useContentBlockStore} from "@/store/contentBlockStore";
const contentBlockStore = useContentBlockStore();
</script>
