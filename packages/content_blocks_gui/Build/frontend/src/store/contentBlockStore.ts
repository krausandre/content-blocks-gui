import {defineStore} from "pinia";

export const useContentBlockStore = defineStore('contentBlock',{
  state:() => ({
    vendor: "contentblocks",
    name:"contentblocks-gui"
  }),
  getters: {
    getName: state => state.name,  // Getter um Namen zu lesen
  },
  actions: {
    setName(newName: string) {
      this.name = newName;  // Aktion um Namen zu ändern
    },
  },
});
