export interface ContentBlockField {
}

export interface Yaml {
  table: string;
  typeField: string;
  fields: ContentBlockField[];
}

export type IconProvider = 'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\SvgIconProvider';

export class ContentBlock {
  // @todo mode: 'new' | 'edit' = 'edit';
  name: string = '';
  yaml: Yaml = {} as Yaml;
  icon: string = '';
  iconProvider: IconProvider = 'TYPO3\\CMS\\Core\\Imaging\\IconProvider\\SvgIconProvider';
  hostExtension: string = '';
  extPath: string = '';
  languageFile: {} = {};

  isContenttype(): boolean {
    return this.yaml.table === 'tt_content';
  }

  isPagetype(): boolean {
    return this.yaml.table === 'pages';
  }
}
