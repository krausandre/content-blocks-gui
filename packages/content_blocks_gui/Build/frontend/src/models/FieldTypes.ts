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
        iconIdentifier: 'apps-pagetree-category-collapse-all',
        items: []
      },
      <ContentBlockFieldNew>{
        type: 'Category',
        identifier: '',
        iconIdentifier: 'mimetypes-x-sys_category'
      },
      <ContentBlockFieldNew>{
        type: 'Checkbox',
        identifier: '',
        iconIdentifier: 'form-checkbox'
      },
      <ContentBlockFieldNew>{
        type: 'Color',
        identifier: '',
        iconIdentifier: ''
      },
      <ContentBlockFieldNew>{
        type: 'DateTime',
        identifier: '',
        iconIdentifier: 'form-date-picker'
      },
      <ContentBlockFieldNew>{
        type: 'Email',
        identifier: '',
        iconIdentifier: 'content-elements-mailform',
      },
      <ContentBlockFieldNew>{
        type: 'File',
        identifier: '',
        iconIdentifier: 'apps-filetree-folder-default',
      },
      <ContentBlockFieldNew>{
        type: 'FlexForm',
        identifier: '',
        iconIdentifier: 'mimetypes-open-document-formula',
      },
      <ContentBlockFieldNew>{
        type: 'Folder',
        identifier: '',
        iconIdentifier: 'apps-filetree-folder',
      },
      <ContentBlockFieldNew>{
        type: 'Linebreak',
        identifier: '',
        iconIdentifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Link',
        identifier: '',
        iconIdentifier: 'actions-link',
      },
      <ContentBlockFieldNew>{
        type: 'Number',
        identifier: '',
        iconIdentifier: 'form-number',
      },
      <ContentBlockFieldNew>{
        type: 'Palette',
        identifier: '',
        iconIdentifier: '',
      },
      <ContentBlockFieldNew>{
        type: 'Password',
        identifier: '',
        iconIdentifier: 'form-password',
      },
      <ContentBlockFieldNew>{
        type: 'Radio',
        identifier: '',
        iconIdentifier: 'mimetypes-x-content-link',
      },
      <ContentBlockFieldNew>{
        type: 'Relation',
        identifier: '',
        iconIdentifier: 'mimetypes-x-content-link',
      },
      <ContentBlockFieldNew>{
        type: 'Select',
        identifier: '',
        iconIdentifier: 'form-single-select',
      },
      <ContentBlockFieldNew>{
        type: 'Slug',
        identifier: '',
        iconIdentifier: 'actions-link',
      },
      <ContentBlockFieldNew>{
        type: 'Tab',
        identifier: '',
        iconIdentifier: 'content-tab-item',
      },
      <ContentBlockFieldNew>{
        type: 'Text',
        identifier: '',
        iconIdentifier: 'content-text',
      },
      <ContentBlockFieldNew>{
        type: 'Textarea',
        identifier: '',
        iconIdentifier: 'form-textarea',
      },
    ]
  }
}
