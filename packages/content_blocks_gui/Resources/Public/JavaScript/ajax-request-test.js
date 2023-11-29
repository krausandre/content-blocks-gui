// TODO: remove if vue app can send the specified ajax requests
import AjaxRequest from "@typo3/core/ajax/ajax-request.js";

class AjaxRequestTest {
  constructor() {
    let sendAjaxRequest = this.sendAjaxRequest;
    this.addEventListener(sendAjaxRequest);
  }
  addEventListener(sendAjaxRequest) {

    document.getElementById('ajaxTestBtn').addEventListener("click", function(ev) {
        ev.preventDefault();
        sendAjaxRequest();
    });
  }
  sendAjaxRequest() {
    return new AjaxRequest(TYPO3.settings.ajaxUrls['content_blocks_gui_save_content_type'])
      .post(
        // save content block with content type "Content Element"
        {
          extension: "samples",
          contentType: "content-element",
          mode: "edit",
          contentBlock: {
            vendor: "test-99",
            name: "test-99",
            fields: JSON.stringify([
              {
                identifier: 'header',
                useExistingField: true,
              },
              {
                identifier: 'bodytext',
                type: 'Text',
              }
            ]),
            basics: JSON.stringify([
              'TYPO3/Appearance',
              'TYPO3/Links',
            ]),
          },
        }
        /*
        // save content block with content type "Page Type"
        {
          extension: "samples",
          contentType: "page-type",
          mode: "create",
          contentBlock: {
            vendor: "test-99",
            name: "test-99",
            type: 3242492,
          }
        }
        */
        /*
        // save content block with content type "Record Type"
        {
          extension: "samples",
          contentType: "record-type",
          mode: "create",
          contentBlock: {
            vendor: "test-99",
            name: "test-99",
          }
        }
        */
        // delete content block
        /*
        {
          name: "test-123/test-12",
        }
         */
      )
      .then(async function (response) {
        const resolved = await response.resolve();
        console.log(resolved);
      })
      .catch((error) => {
        console.log(error.statusText);
        return null;
      });
  }
}

export default new AjaxRequestTest();


