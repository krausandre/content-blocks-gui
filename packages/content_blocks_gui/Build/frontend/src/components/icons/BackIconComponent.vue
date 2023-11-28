<template>
  <div v-html="icon"></div> <!-- Nutze v-html, um das SVG-Icon zu rendern -->
</template>

<script setup>
import { ref } from 'vue';

let icon = ref('');

// Rufe das Icon über TYPO3 API ab und speichere das Ergebnis in `icon`
top.TYPO3.Icons.getIcon('actions-arrow-left', 'small').then(svg => {
  icon.value = svg;
});
</script>
