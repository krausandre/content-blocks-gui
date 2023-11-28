<template>
  <div id="tabs-container" :class="customClass" ref="tabContainer">
    <div id="tab-headers">
      <ul>
        <!-- this shows all of the titles -->
        <li v-for="(tab, index) in tabs" :key="index" :class="activeTabIndex == index ? 'active' : ''"
            @click="changeTab(index)" ref="tabHeaders">{{ tab.title }}
        </li>
      </ul>
    </div>
    <!-- this is where the tabs go, in this slot -->
    <div id="active-tab">
      <slot></slot>
    </div>
  </div>
</template>

<script setup>
import {onMounted, ref} from 'vue';

const props = defineProps(['customClass']);
let tabContainer = ref(null);
let tabHeaders = ref(null);
let tabs = ref(null);
let activeTabIndex = ref(0);

onMounted(() => {
  tabs.value = [...tabContainer.value.querySelectorAll('.tab')];
  for (let x of tabs.value) {
    if (x.classList.contains('active')) {
      activeTabIndex = tabs.value.indexOf(x);
    }
  }
})
const changeTab = (index) => {
  activeTabIndex = index;
  for (let x of [...tabs.value, ...tabHeaders.value]) {
    x.classList.remove('active')
  }
  tabs.value[activeTabIndex].classList.add('active')
  tabHeaders.value[activeTabIndex].classList.add('active')
}
</script>

<style>
#tab-headers ul {
  margin: 0;
  padding: 0;
  display: flex;
  border-bottom: 2px solid var(--typo3-component-border-color);
}

#tab-headers ul li {
  list-style: none;
  padding: 1rem 1.25rem;
  position: relative;
  cursor: pointer;
}

#tab-headers ul li.active {
  color: var(--typo3-component-active-color);
  background: var(--typo3-component-active-bg);
  font-weight: bold;
}

#tab-headers ul li.active:after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 0;
  height: 2px;
  width: 100%;
  background: var(--typo3-component-active-border-color);
}

#active-tab, #tab-headers {
  width: 100%;
}

#active-tab {
  padding: 0.75rem;
}
</style>
