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
    return new AjaxRequest(TYPO3.settings.ajaxUrls['content_blocks_gui_save_cb'])
      .post(
        {
          vendor: "test-99",
          name: "test-99",
          extension: "samples",
          fields: JSON.stringify([
            {
              identifier: 'header',
              useExistingField: true,
            }
         ])
        }
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


