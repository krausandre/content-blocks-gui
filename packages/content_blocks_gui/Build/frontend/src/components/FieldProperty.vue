<template>
  <pre>
fieldIdentifier: {{ fieldIdentifier }}
propertyName: {{ propertyName }}
modelValue: {{ modelValue }}
  </pre>
  <input class=form-control v-model="value"/>
</template>

<script setup>
import {useContentBlockStore} from "@/store/contentBlockStore";
import {computed} from 'vue'

const contentBlockStore = useContentBlockStore();

const props = defineProps(
    {
      modelValue: String,
      fieldIdentifier: String,
      propertyName: String,
    }
)
const emit = defineEmits(['update:modelValue'])

const value = computed(
    {
      get() {
        console.log('g')
        return props.modelValue
      },
      set(value) {
        console.log('s')
        contentBlockStore.setFieldValue(props.fieldIdentifier, props.propertyName, value)
        emit('update:modelValue', value)
      }
    }
)
</script>
