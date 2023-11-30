import type {ContentBlockField} from "@/models/ContentBlock";
import {ContentBlockFieldNew} from "@/models/ContentBlock";

const fieldTypes: {
  [type: string]: {
    componentName: string, iconIdentifier: string, typeLabel: string
  }
} = {
  text: {
    componentName: 'TextFieldType',
    iconIdentifier: 'form-text',
    typeLabel: 'Text',
  },
  textarea: {
    componentName: 'TextAreaFieldType',
    iconIdentifier: 'form-textarea',
    typeLabel: 'Textarea',
  },
  checkbox: {
    componentName: 'CheckboxFieldType',
    iconIdentifier: 'form-checkbox',
    typeLabel: 'Checkbox',
  },
}

export class FieldTypes {
  static componentName(field: ContentBlockField): string {
    return fieldTypes[field.type].componentName ?? 'unknown';
  }

  static iconIdentifier(field: ContentBlockField): string {
    return fieldTypes[field.type].iconIdentifier ?? 'unknown';
  }

  static typeLabel(field: ContentBlockField): string {
    return fieldTypes[field.type].typeLabel ?? 'unknown';
  }

  static draggableVanillaFieldTypes(): ContentBlockFieldNew[] {
    return [
      {
        type: 'text',
        identifier: 'text',
        default: '',
        required: false,
        minLength: 0,
        maxLength: 255,
        size: 255,
        placeholder: '',
        valuePicker: [],
      },
      {
        type: "textarea",
        identifier: 'textarea',
        default: '',
        placeholder: '',
        rows: 5,
        required: false,
        enableRichtext: false,
        richtextConfiguration: 255
      },
      {
        type: "checkbox",
        identifier: 'checkbox',
        default: false,
        required: false,
        items: [],
      }
    ]
  }
}
