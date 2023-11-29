import {defineStore} from "pinia";
import axios from "axios";

export const useGroupListStore = defineStore('groupList', {
  state: () => ({
    list: [] as string[]
  }),
  getters: {
    getList: state => state.list,
  },
  actions: {
    setList(newItems: string[]) {
      this.list = newItems;
    },
    fetch() {
      if (this.getList.length > 0) {
        return;
      }

      axios.get(TYPO3.settings.ajaxUrls.content_blocks_gui_list_groups)
        .then(
          response => this.setList(response.data.body.groupList)
        )
        .catch(
          error => {
            console.log(error)
          }
        );
    }
  },
});
