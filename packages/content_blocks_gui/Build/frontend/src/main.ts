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
import { defineRule, configure } from 'vee-validate';
import { plugin, defaultConfig } from '@formkit/vue'
import config from '../formkit.config'

configure({
    validateOnInput: true, // Validiert Felder bei jedem Tastenanschlag
});


defineRule('required', (value: string) => {
    if (!value || !value.length) {
        return 'This field is required';
    }
    return true;
});

defineRule('checkboxRequired', (value: string) => {
    if (!value || !value.length) {
        return 'This checkbox is required';
    }
    return true;
});

defineRule('email', (value: string) => {
    // Field is empty, should pass
    if (!value || !value.length) {
        return true;
    }
    // Check if email
    if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value)) {
        return 'This field must be a valid email';
    }
    return true;
});

defineRule('minLength', (value: string, [min]: any) => {
    if (!value || !value.length) {
        return true;
    }
    if (value.length < min) {
        return `This field must be at least ${min} characters`;
    }
    return true;
});

defineRule('maxLength', (value: string, [max]: any) => {
    if (!value || !value.length) {
        return true;
    }
    if (value.length > max) {
        return `This field must be at most ${max} characters`;
    }
    return true;
});

const pinia = createPinia();
const app = createApp(App)

app.use(pinia);
app.use(plugin, defaultConfig);

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
