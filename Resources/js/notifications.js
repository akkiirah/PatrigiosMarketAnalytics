let lastNotificationTime = {};

const NotificationConditionEnum = {
    TIME: {
        property: "itemLastTime",

        check: (value, threshold) => value.includes(threshold),
        message: (itemId, threshold) =>
            `Item wurde verkauft`
    },
    LOW_STOCK: {
        property: "itemStock",
        // Prüft, ob der Lagerbestand kleiner als der übergebene Threshold (z. B. 100) ist
        check: (value, threshold) => parseInt(value, 10) < threshold,
        message: (itemId, threshold) =>
            `Niedriger Lagerbestand für Item (unter ${threshold})`
    }
};

const notificationConfigs = {
    "9218": {
        condition: NotificationConditionEnum.LOW_STOCK,
        threshold: 100000
    },
    "4998": {
        condition: NotificationConditionEnum.TIME,
        threshold: "Sekunden"
    }
};

export function observeToNotificate() {
    let items = document.querySelectorAll('.item-wrap');

    items.forEach(item => {
        let data = getDataAttributes(item);

        if (data && data.itemId && notificationConfigs[data.itemId]) {
            let config = notificationConfigs[data.itemId];
            let value = data[config.condition.property];

            if (value && config.condition.check(value, config.threshold)) {
                if (Notification.permission === "granted") {
                    let itemText = data.itemName;
                    let now = Date.now();

                    if (!lastNotificationTime[itemText] || (now - lastNotificationTime[itemText] > 60000)) {
                        new Notification(itemText, {
                            body: config.condition.message(data.itemId, config.threshold),
                            data: { text: itemText }
                        });
                        lastNotificationTime[itemText] = now;
                    }
                }
            }
        }
    });
}

function getDataAttributes(node) {
    let data = {};
    [].forEach.call(node.attributes, function (attr) {
        if (/^data-/.test(attr.name)) {
            let camelCaseName = attr.name.substr(5).replace(/-(.)/g, function ($0, $1) {
                return $1.toUpperCase();
            });
            data[camelCaseName] = attr.value;
        }
    });
    return data;
}
