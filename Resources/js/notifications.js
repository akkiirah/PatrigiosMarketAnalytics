const notificationConfigs = {
    "9218": {
        property: "itemStock",
        condition: (value) => parseInt(value, 10) < 100
    },
    "4998": {
        property: "itemLastTime",
        condition: (value) => value.includes("Sekunden")
    }
};

export function observeToNotificate() {
    let items = document.querySelectorAll('.item-wrap');

    items.forEach(item => {
        let data = getDataAttributes(item);

        if (data && data.itemId && notificationConfigs[data.itemId]) {
            let config = notificationConfigs[data.itemId];
            let value = data[config.property];

            if (value && config.condition(value)) {
                if (Notification.permission === "granted") {
                    let itemText = item.querySelector('.item-heading').innerHTML;
                    let now = Date.now();

                    if (!lastNotificationTime[itemText] || (now - lastNotificationTime[itemText] > 60000)) {
                        new Notification(itemText, {
                            body: `Bedingung erfüllt für Item ${data.itemId}`,
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
