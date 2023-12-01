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

    // @todo not a good place here
    const [vendor, packageName] = cb.yaml.name.split('/')
    cb.yaml.vendor = vendor;
    cb.yaml.name = packageName;

    const data = {
      contentType: ContentBlock.contentType(cb),
      contentBlock: cb.yaml,
      extension: 'samples',
      mode: contentBlockStore.getMode,
    }

    console.log('Saving', data)

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
