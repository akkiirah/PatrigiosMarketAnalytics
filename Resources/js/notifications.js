let lastNotificationTime = {};

export function observeToNotificate() {
    let items = document.querySelectorAll('.item-wrap');

    items.forEach(item => {
        let lastTimeEl = item.querySelector('.item-last-time');
        if (lastTimeEl && lastTimeEl.innerHTML.includes('Sekunden')) {
            if (Notification.permission === "granted") {
                let itemText = item.querySelector('.item-heading').innerHTML;
                let now = Date.now();

                if (!lastNotificationTime[itemText] || (now - lastNotificationTime[itemText] > 60000)) {
                    new Notification(itemText, {
                        body: 'wurde verkauft.',
                        data: { text: itemText }
                    });
                    lastNotificationTime[itemText] = now;
                }
            }
        }
    });
}
