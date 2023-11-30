import Notification from '@typo3/backend/notification.js';


export const shootNoticeNotification = (title, message, duration = 5) => {
    Notification.notice(title, message, duration);
}

export const shootInfoNotification = (title, message, duration = 5) => {
    Notification.info(title, message, duration);
}

export const shootSuccessNotification = (title, message, duration = 5) => {
    Notification.success(title, message, duration);
}

export const shootWarningNotification = (title, message, duration = 5) => {
    Notification.warning(title, message, duration);
}

export const shootErrorNotification = (title, message, duration = 5) => {
    Notification.error(title, message, duration);
}

