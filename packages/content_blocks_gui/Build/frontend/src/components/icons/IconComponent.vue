<template>
  <div v-html="icon"></div> <!-- Nutze v-html, um das SVG-Icon zu rendern -->
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
  identifier: {
    type: String,
    required: true,
  },
  size: {
    type: String,
    default: 'small',
  },
});

let icon = ref('');

// Rufe das Icon über TYPO3 API ab und speichere das Ergebnis in `icon`
top.TYPO3.Icons.getIcon(props.identifier, props.size).then(svg => {
  icon.value = svg;
});

</script>
