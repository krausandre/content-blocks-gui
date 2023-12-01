import './assets/main.css'

import EditView from "@/views/EditView.vue";
import ListView from "@/views/ListView.vue";

import BaseFieldType from "@/components/fieldTypes/BaseFieldType.vue";
import CategoryFieldType from "@/components/fieldTypes/CategoryFieldType.vue";
import CheckboxFieldType from "@/components/fieldTypes/CheckboxFieldType.vue";
import CollectionFieldType from "@/components/fieldTypes/CollectionFieldType.vue";
import ColorFieldType from "@/components/fieldTypes/ColorFieldType.vue";
import DateTimeFieldType from "@/components/fieldTypes/DateTimeFieldType.vue";
import EMailFieldType from "@/components/fieldTypes/EMailFieldType.vue";
import FileFieldType from "@/components/fieldTypes/FileFieldType.vue";
import FolderFieldType from "@/components/fieldTypes/FolderFieldType.vue";
import ImageFieldType from "@/components/fieldTypes/ImageFieldType.vue";
import LineBreakFieldType from "@/components/fieldTypes/LineBreakFieldType.vue";
import NumberFieldType from "@/components/fieldTypes/NumberFieldType.vue";
import TextFieldType from '@/components/fieldTypes/TextFieldType.vue'
import TextAreaFieldType from "@/components/fieldTypes/TextAreaFieldType.vue";
import ExistingFieldType from "@/components/fieldTypes/ExistingFieldType.vue";

import {createApp} from 'vue';
import App from '@/App.vue'
import {createPinia} from 'pinia'

const pinia = createPinia();
const app = createApp(App)

app.use(pinia);

app.component('ListView', ListView)
app.component('EditView', EditView)

app.component('BaseFieldType', BaseFieldType)
app.component('CategoryFieldType', CategoryFieldType)
app.component('CheckboxFieldType', CheckboxFieldType)
app.component('CollectionFieldType', CollectionFieldType)
app.component('ColorFieldType', ColorFieldType)
app.component('DateTimeFieldType', DateTimeFieldType)
app.component('EMailFieldType', EMailFieldType)
app.component('ExistingFieldType', ExistingFieldType)
app.component('FileFieldType', FileFieldType)
app.component('FolderFieldType', FolderFieldType)
app.component('ImageFieldType', ImageFieldType)
app.component('LineBreakFieldType', LineBreakFieldType)
app.component('NumberFieldType', NumberFieldType)
app.component('TextFieldType', TextFieldType)
app.component('TextAreaFieldType', TextAreaFieldType)

app.mount('#app')
