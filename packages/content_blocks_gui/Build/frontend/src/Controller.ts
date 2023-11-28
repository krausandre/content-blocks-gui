import {useContentBlockStore} from "./store/contentBlockStore";

export class Controller {
    saveCb() {
        console.log('saveCb');

        const data = useContentBlockStore().getAsJson;
        fetch(
            TYPO3.settings.ajaxUrls.content_blocks_gui_save_cb,
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
