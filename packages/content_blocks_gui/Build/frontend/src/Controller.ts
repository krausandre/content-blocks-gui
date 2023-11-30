import {useContentBlockStore} from "./store/contentBlockStore";
import {ContentBlock} from "@/models/ContentBlock";
import axios from "axios";

export class Controller {
  saveCb() {
    const cb = useContentBlockStore().contentBlock;

    // @todo
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
        console.log(response.data);
      }
    ).catch(
      error => {
        console.error('Error:', error);
      }
    );
  }
}

const controller = new Controller();
export default controller;
