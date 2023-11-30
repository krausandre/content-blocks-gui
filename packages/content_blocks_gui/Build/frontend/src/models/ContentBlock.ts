export class ContentBlockField {
  identifier: string = '';
  required?: boolean = false;

  // @todo:
  [key: string]: any;
}

type ContentBlockFieldType
  = 'Text' | 'Textarea' | 'Checkbox' | 'Link' | 'Collection'

export class ContentBlockFieldNew extends ContentBlockField {
  type: ContentBlockFieldType = 'Text';
  autocomplete?: boolean;
  allowedTypes?: string[];
  allowed?: string;
  max?: number;
  minitems?: number;
  maxitems?: number;
  enableRichtext?: boolean;
  fields?: ContentBlockField[] = []; // Collection only
}

export class ContentBlockFieldExisting extends ContentBlockField {
  useExistingField: boolean = true;
}

export class Yaml {
  table: string = '';
  typeField: string = '';
  fields: ContentBlockField[] = [];
  basics?: string[] = [];
}

export type IconProvider = 'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\SvgIconProvider';

export class ContentBlock {
  name: string = '';
  // @todo is about to come in _get_cb:
  vendor?: string = '';
  yaml: Yaml = new Yaml();
  icon: string = '';
  iconProvider: IconProvider = 'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\SvgIconProvider';
  hostExtension: string = '';
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
    return contentBlock.yaml.table === 'tt_content';
  }

  // @todo
  static isPagetype(contentBlock: ContentBlock): boolean {
    return contentBlock.yaml.table === 'pages';
  }

  // @todo
  static asJson(contentBlock: ContentBlock): string {
    return JSON.stringify(contentBlock);
  }
}
