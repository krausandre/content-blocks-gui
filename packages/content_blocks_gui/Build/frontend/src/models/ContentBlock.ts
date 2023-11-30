export class ContentBlockField {
  identifier: string = '';
  required?: boolean = false;
  // @todo:
  [key:string]: any;
}

type ContentBlockFieldType
  = 'text' | 'textarea' | 'checkbox';

export class ContentBlockFieldNew extends ContentBlockField {
  type: ContentBlockFieldType = 'text';
  autocomplete?: boolean;
  allowedTypes?: string[];
  allowed?: string;
  max?: number;
  minitems?: number;
  maxitems?: number;
  enableRichtext?: boolean;
}

export class ContentBlockFieldExisting extends ContentBlockField {
  useExistingField: boolean = true;
}

export class Yaml {
  table: string = '';
  typeField: string = '';
  fields: ContentBlockField[] = [];
}

export type IconProvider = 'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\SvgIconProvider';

export class ContentBlock {
  // @todo mode: 'new' | 'edit' = 'edit';
  name: string = '';
  yaml: Yaml = new Yaml();
  icon: string = '';
  iconProvider: IconProvider = 'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\SvgIconProvider';
  hostExtension: string = '';
  extPath: string = '';
  languageFile: {} = {};

  // @todo
  static isContenttype(contentBlock: ContentBlock): boolean {
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
