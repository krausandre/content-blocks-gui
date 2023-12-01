// TODO: remove if vue app can send the specified ajax requests
import AjaxRequest from "@typo3/core/ajax/ajax-request.js";

class AjaxRequestTest {
  constructor() {
    let sendAjaxRequest = this.sendAjaxRequest;
    this.addEventListener(sendAjaxRequest);
  }
   addEventListener(sendAjaxRequest) {
      let btn = document.getElementById('ajaxTestBtn');
      if(btn !== null) {
        btn.addEventListener("click", function(ev) {
          ev.preventDefault();
          sendAjaxRequest();
        });
      }
   }
  sendAjaxRequest() {
    return new AjaxRequest(TYPO3.settings.ajaxUrls['content_blocks_gui_save_translation'])
      .post(
        // {
        //   name: "example/tabs",
        // }

        /*
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
         */
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
        /*
        // save content block with content type "Basic"
        {
          extension: "samples",
          contentType: "basic",
          mode: "create",
          contentBlock: {
            vendor: "test-99",
            name: "test-99",
            fields: JSON.stringify([
              {
                identifier: 'appearance_tab',
                type: 'Tab',
                label: 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance'
              },
              {
                identifier: 'link_tab',
                type: 'Tab',
                label: 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.link'
              }
            ]),
          }
        }
         */
        /* {
        /*
        // copy content block with content type "Content Element"
        {
          extension: "samples_copy",
          contentType: "content-element",
          mode: "copy",
          initialVendor: "test-99",
          initialName: "test-99",
          contentBlock: {
            vendor: "copied-test-99",
            name: "copied-test-99",
            fields: JSON.stringify([
              {
                identifier: 'header',
                useExistingField: true,
              },
              {
                identifier: 'bodytext',
                type: 'Text',
              },
              {
                identifier: 'image',
                type: 'File',
              }
            ]),
          }
        } */
        // delete content block
        /*
        // get/delete/download content block
        {
          name: "example/tabs",
        }
      */
      // saveTranslate
        {
          name: "example/tabs",
          targetLanguage: "de",
          translations: {
            de: {
                title: [
                    {
                        source: "Tabs",
                        target: "Tabs translated"
                    }
                ],
                description: [
                    {
                        source: "Toggle between hiding and showing content with tabs",
                        target: "translated Toggle between hiding and showing content with tabs"
                    }
                ],
                'header.label': [
                    {
                        source: "Header",
                        target: "translated Header"
                    }
                ],
                'tabs_item.label': [
                    {
                        source: "Tabs items",
                        target: "translated Tabs items"
                    }
                ],
                'tabs_item.title.label': [
                    {
                        source: "Title",
                        target: "translated Title"
                    }
                ],
                'tabs_item.textarea.label': [
                    {
                        source: "Content",
                        target: "translated Content"
                    }
                ],
                'fil.kaputis.label': [
                    {
                        source: "irgendwas nicht verständliches auf griechisch",
                        target: "Der Fil auf DE"
                    }
                ]
            }
          }
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


