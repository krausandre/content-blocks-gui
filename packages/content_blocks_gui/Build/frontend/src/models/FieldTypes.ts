import type {ContentBlockField} from "@/models/ContentBlock";
import {ContentBlockFieldExisting, ContentBlockFieldNew} from "@/models/ContentBlock";

type FieldTypeGuiDefinition = {
  componentName: string, iconIdentifier: string, typeLabel: string
}

const guiGenerics: { [type: string]: FieldTypeGuiDefinition } = {
  Text: {
    componentName: 'TextFieldType',
    iconIdentifier: 'form-text',
    typeLabel: 'Text',
  },
  Textarea: {
    componentName: 'TextAreaFieldType',
    iconIdentifier: 'form-textarea',
    typeLabel: 'Textarea',
  },
  Checkbox: {
    componentName: 'CheckboxFieldType',
    iconIdentifier: 'form-checkbox',
    typeLabel: 'Checkbox',
  },
  Link: {
    componentName: 'LinkFieldType',
    iconIdentifier: 'form-link',
    typeLabel: 'Link',
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
      ?? 'BaseFieldType';
  }

  static iconIdentifier(field: ContentBlockField): string {
    if(field.useExistingField ?? false) {
      return existingFieldGuiGenerics.iconIdentifier;
    }

    return guiGenerics[field.type].iconIdentifier
      ?? 'actions-question-circle';
  }

  static typeLabel(field: ContentBlockField): string {
    if(field.useExistingField ?? false) {
      return existingFieldGuiGenerics.typeLabel;
    }

    return guiGenerics[field.type].typeLabel
      ?? `Not implemented (${field.type})`;
  }

  static draggableVanillaFieldTypes(): ContentBlockField[] {
    return [
      <ContentBlockFieldExisting>{
        identifier: 'existing',
        useExistingField: true,
      },
      <ContentBlockFieldNew>{
        type: 'Collection',
        identifier: 'collection',
        required: false,
        fields: [],
      },
      <ContentBlockFieldNew>{
        type: 'Text',
        identifier: 'text',
        default: '',
        required: false,
        minLength: 0,
        maxLength: 255,
        size: 255,
        placeholder: '',
        valuePicker: [],
      },
      <ContentBlockFieldNew>{
        type: 'Textarea',
        identifier: 'textarea',
        default: '',
        placeholder: '',
        rows: 5,
        required: false,
        enableRichtext: false,
        richtextConfiguration: 255
      },
      <ContentBlockFieldNew>{
        type: 'Checkbox',
        identifier: 'checkbox',
        default: false,
        required: false,
        items: [],
      },
      <ContentBlockFieldNew>{
        type: 'Link',
        identifier: 'link',
        default: false,
        required: false,
      },
    ]
  }
}
