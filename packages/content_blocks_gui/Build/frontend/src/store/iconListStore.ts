import {defineStore} from "pinia";
import axios from "axios";

export const useIconListStore = defineStore('iconList', {
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
      axios.get(TYPO3.settings.ajaxUrls.content_blocks_gui_list_icons)
      .then(
        response => {
          console.log(response.data.body)
          this.setList(response.data.body.iconList)
        }
      )
      .catch(
        error => {
          console.log(error)
        }
      );
    },
    getIconByIdentifier(key: string) {
      if (key in this.list) {
        return (this.list as any)[key];
      } else {
        return 'actions-brand-typo3';
      }
    }
  },
});
