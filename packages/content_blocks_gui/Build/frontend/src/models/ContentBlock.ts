export class ContentBlockField {
  identifier: string = '';
  required?: boolean = false;

  // @todo:
  [key: string]: any;
}

type ContentBlockFieldType
  = 'Category' | 'Checkbox' | 'Collection' | 'Color' | 'DateTime' | 'Email' | 'File' | 'FlexForm' | 'Folder'
  | 'Linebreak' | 'Link' | 'Number' | 'Palette' | 'Password' | 'Radio' | 'Relation' | 'Select' | 'Slug'
  | 'Tab' | 'Text' | 'Textarea'

export class ContentBlockFieldNew extends ContentBlockField {
  type: ContentBlockFieldType = 'Text';
  useExistingField?: boolean = false;
  label?: string = '';
  description?: string = '';
  alternativeSql?: string = '';
  prefixField?: boolean = false;
  autocomplete?: boolean;
  allowedTypes?: string[];
  allowed?: string;
  max?: number;
  minitems?: number;
  maxitems?: number;
  enableRichtext?: boolean;
  fields?: ContentBlockField[] = []; // Collection and Flexform only
}

export class ContentBlockFieldExisting extends ContentBlockField {
  useExistingField: boolean = true;
}

export class Yaml {
  // @todo https://github.com/krausandre/content-blocks-gui/issues/2
  name?: string;
  title?: string;
  group?: string = '';
  table: string = '';
  typeField: string = '';
  prefixFields: boolean = false;
  prefixType: 'full' | 'vendor' = 'full';
  vendorPrefix: string = '';
  fields: ContentBlockField[] = [];
  basics?: string[] = [];
}

export type IconProvider = 'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\SvgIconProvider';

export enum PrefixTypes {
  FULL = 'full',
  VENDOR = 'vendor',
}
export class ContentBlock {
  // duplicated from YAML for _save
  name: string = '';
  group?: string = '';
  priority: number = 0;

  // set for _copy
  initialVendor?: string = '';
  initialName?: string = '';

  hostExtension: string = '';

  yaml: Yaml = new Yaml();

  // transient properties, can be ignored
  // icon: string = '';
  // iconProvider: IconProvider = 'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\SvgIconProvider';
  //extPath: string = '';
  //languageFile: {} = {};

  static contentType(contentBlock: ContentBlock): string {
    if (contentBlock.yaml.table === 'tt_content') {
      return 'content-element';
    }
    if (contentBlock.yaml.table === 'pages') {
      return 'page-type';
    }
    if (contentBlock.yaml.table) {
      return 'record-type';
    }
    return 'basic';
  }

  // @todo
  static isContentElement(contentBlock: ContentBlock): boolean {
    return contentBlock.yaml?.table === 'tt_content';
  }

  static setTypeContentElement(contentBlock: ContentBlock): void {
    contentBlock.yaml.table = 'tt_content';
    contentBlock.yaml.typeField = 'CType';
  }

  // @todo
  static isPagetype(contentBlock: ContentBlock): boolean {
    return (contentBlock.yaml?.table ?? '') === 'pages';
  }

  static setTypePagetype(contentBlock: ContentBlock): void {
    contentBlock.yaml.table = 'pages';
  }

  static isTypeRecordType(contentBlock: ContentBlock): boolean {
    // @todo
    return !['pages', 'tt_content'].includes(contentBlock.yaml?.table);
  }

  static setTypeRecordType(contentBlock: ContentBlock): void {
    contentBlock.yaml.table = '';
  }

  static setTypeBasic(contentBlock: ContentBlock): void {
    // @todo
    contentBlock.yaml.table = '@todo basic';
    console.log('@todo: setTypeBasic()')
  }

  static isTypeBasic(contentBlock: ContentBlock): boolean {
    // @todo
    return false;
  }

  // @todo
  static asJson(contentBlock: ContentBlock): string {
    return JSON.stringify(contentBlock);
  }

  static typeString(contentBlock: ContentBlock): string {
    if (ContentBlock.isContentElement(contentBlock)) {
      return 'Content Element';
    }
    if (ContentBlock.isPagetype(contentBlock)) {
      return 'Page Type';
    }
    if (ContentBlock.isTypeRecordType(contentBlock)) {
      return 'Record Type (or @todo Basic)';
    }
    return 'Basic';
  }
}
