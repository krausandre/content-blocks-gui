import {defineStore} from "pinia";

export const useContentBlocksListStore = defineStore('contentBlocksList',{
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
