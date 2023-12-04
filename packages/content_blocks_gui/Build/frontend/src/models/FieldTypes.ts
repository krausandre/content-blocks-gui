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
    iconIdentifier: 'actions-link',
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
  iconIdentifier: 'mimetypes-x-content-link',
  typeLabel: 'Existing Field',
}

export class FieldTypes {
  static componentName(field: ContentBlockField): string {
    if (field.useExistingField ?? false) {
      return existingFieldGuiGenerics.componentName;
    }

    return guiGenerics[field.type]?.componentName
      ?? 'BaseFieldType';
  }

  static iconIdentifier(field: ContentBlockField): string {
    if (field.useExistingField ?? false) {
      return existingFieldGuiGenerics.iconIdentifier;
    }

    return guiGenerics[field.type]?.iconIdentifier
      ?? 'actions-question-circle';
  }

  static typeLabel(field: ContentBlockField): string {
    if (field.useExistingField ?? false) {
      return existingFieldGuiGenerics.typeLabel;
    }

    return guiGenerics[field.type]?.typeLabel
      ?? `Not implemented (${field.type})`;
  }

  static draggableVanillaFieldTypes(): ContentBlockField[] {
    return [
      <ContentBlockFieldExisting>{
        identifier: '',
        useExistingField: true,
      },
      <ContentBlockFieldNew>{
        type: 'Collection',
        identifier: '',
        items: []
      },
      <ContentBlockFieldNew>{
        type: 'Category',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Checkbox',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Color',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'DateTime',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Email',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'File',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'FlexForm',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Folder',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Linebreak',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Link',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Number',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Palette',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Password',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Radio',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Relation',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Select',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Slug',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Tab',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Text',
        identifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Textarea',
        identifier: '',
      },
    ]
  }
}
