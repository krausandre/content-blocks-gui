import {defineStore} from "pinia";
import {ContentBlock} from "@/models/ContentBlock";

export const useContentBlockStore = defineStore(
  'contentBlock',
  {
    state: () => (
      {
        contentBlock: new ContentBlock(),
      }
    ),
    getters: {
      getFields: state => state.contentBlock.yaml.fields,
      getContentBlock: state => state.contentBlock,
      getAsJson: state => JSON.stringify(state.contentBlock)
    },
    actions: {
      resetContentBlock(table: string) {
        this.$reset()
        this.contentBlock.yaml.table = table;
      },
      setContentBlock(newContentBlock: ContentBlock) {
        this.contentBlock = newContentBlock;
      },
      setFields(newFields: any[]) {
        this.contentBlock.yaml.fields = newFields;
      }
    },
  }
);
