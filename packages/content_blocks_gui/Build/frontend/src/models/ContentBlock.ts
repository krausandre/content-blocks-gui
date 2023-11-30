export class ContentBlockField {
  identifier: string = '';
  useExistingField: boolean = false;
  properties: any = {};
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
