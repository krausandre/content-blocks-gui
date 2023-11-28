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
    return new AjaxRequest(TYPO3.settings.ajaxUrls['download_cb'])
      .post(
        {
          identifier: "test-12/test-12"
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


