import {useContentBlockStore} from "@/store/contentBlockStore";
import {useGlobalPropertiesStore} from "@/store/globalPropertiesStore";
import {ContentBlock} from "@/models/ContentBlock";
import axios from "axios";


export class Controller {
  saveCb() {
    const cb = useContentBlockStore().contentBlock;
    const globalPropertiesStore = useGlobalPropertiesStore();

    globalPropertiesStore.setIsLoading(true);
    axios.postForm(
      TYPO3.settings.ajaxUrls.content_blocks_gui_save_content_type,
      {
        contentType: ContentBlock.contentType(cb),
        contentBlock: ContentBlock.asJson(cb),
        extension: 'samples',
        // @todo mode: 'create' | 'copy' | 'edit';
        mode: 'edit',
      }
    ).then(
      response => {
        globalPropertiesStore.setIsLoading(false);
        console.log(response.data);
      }
    ).catch(
      error => {
        globalPropertiesStore.setIsLoading(true);
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
  //COPY = 'copy',
  EDIT = 'edit',
}
