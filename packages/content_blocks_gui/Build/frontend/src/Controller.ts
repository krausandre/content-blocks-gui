import axios from "axios";
import {toRaw} from "vue";
import {ContentBlock} from "@/models/ContentBlock";
import {shootErrorNotification, shootSuccessNotification} from "@/helper/typo3NotificationHelper.js";
import {useContentBlockStore} from "@/store/contentBlockStore";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";


export class Controller {
  saveCb() {
    const contentBlockStore = useContentBlockStore();
    const globalPropertiesStore = useGlobalPropertiesStore();

    // @todo – this makes sure we drop type information and hydrate fine but looks funny of course
    const cb = JSON.parse(JSON.stringify(toRaw<ContentBlock>(contentBlockStore.contentBlock)))


    // @todo: check if name and initialName is redundant at this point
    const data = {
      contentType: ContentBlock.contentType(cb),
      contentBlock: cb.yaml,
      extension: contentBlockStore.contentBlock.hostExtension,
      mode: contentBlockStore.mode,
      initialVendor: contentBlockStore.contentBlock.initialVendor,
      name: contentBlockStore.contentBlock.name,
      initialName: contentBlockStore.contentBlock.initialName,
    }

    console.log('Saving', JSON.stringify(data));

    globalPropertiesStore.setIsLoading(true);
    axios.postForm(
      TYPO3.settings.ajaxUrls.content_blocks_gui_save_content_type,
      data
    ).then(
      response => {
        globalPropertiesStore.setIsLoading(false);
        console.log(response.data);
        if (!response.data.success) {
          throw new Error(response.data.message);
        }
        shootSuccessNotification(
          'Ok',
          'saved',
        )
      }
    ).catch(
      error => {
        globalPropertiesStore.setIsLoading(false);
        shootErrorNotification(
          'Error',
          error.message,
        )
        console.error('Error:', error);
      }
    );
  }
}

const controller = new Controller();
export default controller;

export enum AppMainView {
  EDIT_VIEW = 'EditView',
  LIST_VIEW = 'ListView',
}

export enum AppEditMode {
  CREATE = 'create',
  COPY = 'copy',
  EDIT = 'edit',
}
