import {defineStore} from "pinia";
import axios from "axios";
import {shootErrorNotification} from "@/helper/typo3NotificationHelper.js";

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
      axios.get(
        TYPO3.settings.ajaxUrls.content_blocks_gui_list_icons
      ).then(
        response => {
          console.log(response.data.body)
          if (!response.data.success) {
            throw new Error(response.data.message);
          }
          this.setList(response.data.body.iconList)
        }
      ).catch(
        error => {
          shootErrorNotification(
            'Error',
            error.message,
          )
          console.error('Error:', error);
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
