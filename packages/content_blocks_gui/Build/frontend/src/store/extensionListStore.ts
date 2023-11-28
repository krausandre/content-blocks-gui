import {defineStore} from "pinia";

export const useExtensionListStore = defineStore('extensionList',{
  state:() => ({
    list: [] as string[]
  }),
  getters: {
    getList: state => state.list,
  },
  actions: {
    setList(newItems: string[]) {
      this.list = newItems;
    },
  },
});
