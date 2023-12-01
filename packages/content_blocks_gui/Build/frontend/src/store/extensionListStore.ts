import {defineStore} from "pinia";
import axios from "axios";
import {shootErrorNotification} from "@/helper/typo3NotificationHelper.js";

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
          response => {
            if (!response.data.success) {
              throw new Error(response.data.message);
            }
            this.setList(response.data.body.list)
          }
        )
        .catch(
          error => {
            shootErrorNotification(
              'Error',
              error.message,
            )
            console.error('Error:', error);
          }
        );
    }
  },
});
