import {defineStore} from "pinia";
import axios from "axios";

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
    fetch() {
      if (this.getList.length > 0) {
        return;
      }

      axios.get(TYPO3.settings.ajaxUrls.content_blocks_gui_list_ext)
        .then(
          response => this.setList(response.data.body.list)
        )
        .catch(
          error => {
            console.log(error)
          }
        );
    }
  },
});
