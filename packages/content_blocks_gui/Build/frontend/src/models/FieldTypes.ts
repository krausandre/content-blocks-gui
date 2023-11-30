import type {ContentBlockField} from "@/models/ContentBlock";

type FieldTypeGuiDefinition = {
  componentName: string, iconIdentifier: string, typeLabel: string
}

const guiGenerics: { [type: string]: FieldTypeGuiDefinition } = {
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
  Collection: {
    componentName: 'CollectionFieldType',
    iconIdentifier: 'actions-refresh',
    typeLabel: 'Collection'
  }
}

const existingFieldGuiGenerics: FieldTypeGuiDefinition = {
  componentName: 'ExistingFieldType',
  iconIdentifier: 'actions-link',
  typeLabel: 'Existing Field',
}

export class FieldTypes {
  static componentName(field: ContentBlockField): string {
    if(field.useExistingField ?? false) {
      return existingFieldGuiGenerics.componentName;
    }

    return guiGenerics[field.type].componentName
      ?? '';
  }

  static iconIdentifier(field: ContentBlockField): string {
    if(field.useExistingField ?? false) {
      return existingFieldGuiGenerics.iconIdentifier;
    }

    return guiGenerics[field.type].iconIdentifier
      ?? '';
  }

  static typeLabel(field: ContentBlockField): string {
    if(field.useExistingField ?? false) {
      return existingFieldGuiGenerics.typeLabel;
    }

    return guiGenerics[field.type].typeLabel
      ?? '';
  }

  static draggableVanillaFieldTypes(): ContentBlockField[] {
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
      },
      {
        type: "Collection",
        identifier: 'collection',
        required: false,
        fields: [],
      },
      {
        identifier: 'existing',
        useExistingField: true,
      }
    ]
  }
}
