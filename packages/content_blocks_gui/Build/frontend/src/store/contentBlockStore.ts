import {defineStore} from "pinia";
import {ContentBlock, ContentBlockField} from "@/models/ContentBlock";
import {AppEditMode} from "@/Controller";

export const useContentBlockStore = defineStore(
  'contentBlock',
  {
    state: () => (
      {
        contentBlock: new ContentBlock(),
        mode: AppEditMode.CREATE as AppEditMode,
      }
    ),
    getters: {
      getFields: state => state.contentBlock.yaml?.fields ?? [],
      getContentBlock: state => state.contentBlock,
      getMode: state => state.mode,
    },
    actions: {
      resetContentBlock() {
        this.$reset()
        this.setMode(AppEditMode.CREATE)
      },
      setContentBlock(newContentBlock: ContentBlock) {
        this.contentBlock = newContentBlock;
      },
      setMode(mode: AppEditMode) {
        this.mode = mode;
      },
      setFields(newFields: any[]) {
        this.contentBlock.yaml.fields = newFields;
      },
      getFieldValue(fieldIdentifier: string, propertyName: string): string {
        const field: ContentBlockField | undefined = this.contentBlock.yaml.fields.find(
          field => field.identifier === fieldIdentifier
        );
        if (field === undefined) {
          return '';
        }
        return field[propertyName] ?? '';
      },
      setFieldValue(fieldIdentifier: string, propertyName: string, value: string): void {
        const field: ContentBlockField | undefined = this.contentBlock.yaml.fields.find(
          field => field.identifier === fieldIdentifier
        );
        if (field === undefined || field[propertyName] === undefined) {
          return;
        }
        console.log(`setting ${fieldIdentifier} / ${propertyName} = ${value}`)
        field[propertyName] = value;
      }
    },
  }
);
