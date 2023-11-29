import {useContentBlockStore} from "./store/contentBlockStore";
import {ContentBlock} from "@/models/ContentBlock";

export class Controller {
  saveCb() {
    console.log('saving', useContentBlockStore().contentBlock)
    const data = ContentBlock.asJson(useContentBlockStore().contentBlock)
    fetch(
      TYPO3.settings.ajaxUrls.content_blocks_gui_save_content_type,
      {
        method: 'POST',
        body: JSON.stringify(data),
        headers: {'Content-Type': 'application/json'},
      }
    )
      .then(
        (response) => response.json()
      )
      .then(
        (data) => {
          console.log('Success:', data);
        }
      )
      .catch(
        (error) => {
          console.error('Error:', error);
        }
      );
  }
}

const controller = new Controller();
export default controller;
