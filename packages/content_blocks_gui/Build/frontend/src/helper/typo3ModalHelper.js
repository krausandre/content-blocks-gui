import Modal from '@typo3/backend/modal.js';


export const shootConfirmModal = (title, message) => {
    Modal.confirm(
        title,
        message,
        0, [
            {
                text: 'OK!',
                trigger: function() {
                    top.TYPO3.Modal.dismiss();
                }
            }
        ]
    );
}

export const shootWarningModal = (title, message) => {
    Modal.confirm(
        title,
        message,
        1,
        [
            {
                text: 'OK!',
                trigger: function() {
                    top.TYPO3.Modal.dismiss();
                }
            }
        ],
    )
}

export const shootDangerModal = (
    title,
    message,
    okayFunction = () => top.TYPO3.Modal.dismiss()
) => {
    Modal.confirm(
        title,
        message,
        2,
        [
            {
                text: "Cancel",
                trigger: function() {
                  top.TYPO3.Modal.dismiss();
                }
            },
            {
                text: 'Okay',
                btnClass:"btn-danger",
                trigger: function() {
                  okayFunction();
                  top.TYPO3.Modal.dismiss();
                }
            }
        ],
    )
}
export const shootPrimaryModal = (title, message) => {
    Modal.confirm(
        title,
        message,
        3,
        [
            {
                text: 'OK!',
                trigger: function() {
                    top.TYPO3.Modal.dismiss();
                }
            }
        ],
    )
}
