import {defineStore} from "pinia";

export const useContentBlockStore = defineStore('contentBlock',{
  state:() => ({
    vendor: "contentblocks",
    package:"contentblocks-gui",
    extensionKey: "ext_content_blocks_gui",
    fields: [] as any[],
  }),
  getters: {
    getVendor: state => state.vendor,
    getPackage: state => state.package,
    getExtensionKey: state => state.extensionKey,
    getFields: state => state.fields,
    getAsJson: state => JSON.stringify(
        {
            vendor: state.vendor,
            package: state.package,
            extensionKey: state.extensionKey,
        }
    ),
  },
  actions: {
    setVendor(newVendor: string) {
      this.vendor = newVendor;  // Aktion um Namen zu ändern
    },
    setPackage(newPackage: string) {
      this.package = newPackage;  // Aktion um Namen zu ändern
    },
    setExtensionKey(newExtensionKey: string) {
      this.extensionKey = newExtensionKey;  // Aktion um Namen zu ändern
    },
    setFields(newFields: any[]) {
      this.fields = newFields;
    }
  },
});
