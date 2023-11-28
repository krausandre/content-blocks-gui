import {defineStore} from "pinia";

export const useContentBlockStore = defineStore('contentBlock',{
  state:() => ({
    vendor: "contentblocks",
    package:"contentblocks-gui",
    extensionKey: "ext_content_blocks_gui",
  }),
  getters: {
    getVendor: state => state.vendor,
    getPackage: state => state.package,
    getExtensionKey: state => state.extensionKey,
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
  },
});