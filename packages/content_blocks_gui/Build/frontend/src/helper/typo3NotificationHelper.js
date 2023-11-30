import Notification from '@typo3/backend/notification.js';

export const shootSuccessNotification = (title, message) => {
    Notification.success(title, message);
}

export const shootInfoNotification = (title, message) => {
    Notification.info(title, message);
}
