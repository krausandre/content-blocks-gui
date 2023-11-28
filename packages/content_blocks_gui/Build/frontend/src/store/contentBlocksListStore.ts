import {defineStore} from "pinia";

export const useContentBlocksListStore = defineStore('contentBlocksList',{
  state:() => ({
    list: [] as any
  }),
  getters: {
    getList: state => state.list,
  },
  actions: {
    setList(newItems: any) {
      this.list = newItems;
    },
  },
});
