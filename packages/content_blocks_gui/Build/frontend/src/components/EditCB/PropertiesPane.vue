<template>
  <Tabs>
    <Tab active="true" title="Global">
      <div class="d-flex flex-column">
        <div class="mb-3">
          <span>current selected element: {{ globalPropertiesStore.getCurrentSelectedFieldIdentifier }}</span>
          <pre>
            {{ contentBlockStore.getFields }}
          </pre>
        </div>

<!--        @todo: einzelne Input Felder in Komponenten auslagern. Nicht alles wird für alles benötigt. Size zum Beispiel nur für input, select, etc. -->
        <div>
          <h3>Benötigte Felder</h3>
          <div>
            <div class="mb-3">
              <label for="defaultValue" class="form-label">Identifier</label>
              <input type="text" class="form-control" id="defaultValue" aria-describedby="defaultValue">
              <div id="defaultValueHelp" class="form-text">Default value set if a new record is created.</div>
            </div>
          </div>
          <div>
            <div class="mb-3">
              <label for="defaultValue" class="form-label">Label</label>
              <input type="text" class="form-control" id="defaultValue" aria-describedby="defaultValue">
              <div id="defaultValueHelp" class="form-text">Default value set if a new record is created.</div>
            </div>
          </div>
          <div>
            <div class="mb-3">
              <label for="defaultValue" class="form-label">Description</label>
              <input type="text" class="form-control" id="defaultValue" aria-describedby="defaultValue">
              <div id="defaultValueHelp" class="form-text">Default value set if a new record is created.</div>
            </div>
          </div>
          <div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="required" aria-describedby="required">
              <label for="required" class="form-check-label">use existing field?</label>
            </div>
          </div>
          <div>
            <div class="mb-3">
              <label for="defaultValue" class="form-label">prefixField</label>
              <input type="text" class="form-control" id="defaultValue" aria-describedby="defaultValue">
              <div id="defaultValueHelp" class="form-text">Default value set if a new record is created.</div>
            </div>
          </div>
          <div>
            <div class="mb-3">
              <label for="defaultValue" class="form-label">prefixType</label>
              <input type="text" class="form-control" id="defaultValue" aria-describedby="defaultValue">
              <div id="defaultValueHelp" class="form-text">Default value set if a new record is created.</div>
            </div>
          </div>
          <div>
            <div class="mb-3">
              <label for="defaultValue" class="form-label">displayCond</label>
              <input type="text" class="form-control" id="defaultValue" aria-describedby="defaultValue">
              <div id="defaultValueHelp" class="form-text">Default value set if a new record is created.</div>
            </div>
          </div>
          <div>
            onChange
          </div>
        </div>
        <div>
          <label for="@todo" class="form-label">Default value</label>
          <FieldProperty :field-identifier="globalPropertiesStore.getCurrentSelectedFieldIdentifier"
                         property-name="default"
                         :model-value="contentBlockStore.getFieldValue(
                             globalPropertiesStore.getCurrentSelectedFieldIdentifier,
                              'default'
                              )"
          />
        </div>

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
      </div>
    </Tab>
    <Tab title="Validation"/>
  </Tabs>
</template>

<script setup lang="ts">
import Tab from "@/components/Tab.vue";
import Tabs from "@/components/Tabs.vue";

import {useContentBlockStore} from "@/store/contentBlockStore";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import FieldProperty from "@/components/FieldProperty.vue";

const contentBlockStore = useContentBlockStore();
const globalPropertiesStore = useGlobalPropertiesStore();

</script>
