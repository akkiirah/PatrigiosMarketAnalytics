import { buildMenu } from './menu.js';
let lastNotificationTime = {};
const itemsWrap = document.querySelector('.items-wrap');

window.addEventListener('DOMContentLoaded', function () {

    loadCategories();

    if (document.getElementById('itemsContainer') && document.getElementById('itemsContainer').classList.contains('list')) {
        initItemsList(itemsWrap);
        setupPagination();
        setupAmount();
    }

    if (document.getElementById('itemsContainer') && document.getElementById('itemsContainer').classList.contains('start')) {
        distributeItems(itemsWrap);
        window.addEventListener('resize', debounce(() => distributeItems(itemsWrap), 100));
        refreshData(5);
    }

    Notification.requestPermission();

    generateHomeLink();
});

function distributeItems(itemsWrap) {

    const screenWidth = window.innerWidth;
    let maxColumns;

    if (screenWidth <= 1024) maxColumns = 1;
    else if (screenWidth <= 1500) maxColumns = 2;
    else maxColumns = 3;

    const items = Array.from(itemsWrap.querySelectorAll('.item-wrap'));
    itemsWrap.innerHTML = '';

    const columns = Array.from({ length: maxColumns }, () => {
        const column = document.createElement('div');
        column.classList.add('column');
        return column;
    });

    items.forEach((item, index) => {
        const columnIndex = index % maxColumns;
        columns[columnIndex].appendChild(item);
    });

    columns.forEach(column => itemsWrap.appendChild(column));
    initItemsList(itemsWrap)
}

function initItemsList(itemsWrap) {
    setTimeout(() => {
        itemsWrap.classList.add('initialized');

    }, 250);
}

function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function refreshData(waitInSecs) {
    setTimeout(() => {
        fetch(new URLSearchParams(window.location.search))
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('#itemsContainer');

                if (newContent) {
                    document.querySelector('#itemsContainer').innerHTML = newContent.innerHTML;
                } else {
                    console.error("Kein neuer Inhalt gefunden!");
                }

                let itemsWrap = document.querySelector('.items-wrap');
                distributeItems(itemsWrap);
                refreshData(waitInSecs);
                window.addEventListener('resize', debounce(() => distributeItems(itemsWrap), 100));
                observeToNotificate();
            })
            .catch(error => console.error('Fehler beim Laden der neuen Seite:', error));
    }, (1000 * waitInSecs));
}

function loadCategories() {
    fetch('Resources/json/categories.json')
        .then(response => {
            if (!response.ok) {
                throw new Error('Netzwerkantwort war nicht ok');
            }
            return response.json();
        })
        .then(data => {
            buildMenu(data);
        })
        .catch(error => {
            console.error('Fehler beim Laden der JSON-Datei:', error);
        });
}

function setupPagination() {
    document.addEventListener('click', function (event) {
        if (event.target.matches('#prevButton, #indexButton, #nextButton')) {
            if (event.target.disabled) {
                return;
            }
            event.preventDefault();
            document.querySelector('.items-wrap').classList.remove('initialized');
            const newPage = event.target.getAttribute('data-page');

            const urlParams = new URLSearchParams(window.location.search);
            let paramsStr = urlParams.get('params') || '{}';
            paramsStr = paramsStr.substring(1, paramsStr.length - 1);

            let paramsObj = {};
            paramsStr.split(',').forEach(pair => {
                let [key, value] = pair.split(':');
                if (key && value) {
                    paramsObj[key.trim()] = value.trim();
                }
            });
            paramsObj['page'] = newPage;

            let newParamsStr = '{' + Object.entries(paramsObj)
                .map(([key, value]) => `${key}:${value}`)
                .join(',') + '}';

            urlParams.set('params', newParamsStr);
            urlParams.delete('page');
            urlParams.delete('amount');

            const newUrl = window.location.pathname + '?' + urlParams.toString();

            history.pushState(null, '', newUrl);

            fetch(newUrl)
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('#itemsContainer');

                    if (newContent) {
                        document.querySelector('#itemsContainer').innerHTML = newContent.innerHTML;
                    } else {
                        console.error("Kein neuer Inhalt gefunden!");
                    }

                    let itemsWrap = document.querySelector('.items-wrap');
                    document.body.scrollTop = document.documentElement.scrollTop = 0;
                    initItemsList(itemsWrap);
                })
                .catch(error => console.error('Fehler beim Laden der neuen Seite:', error));
        }
    });
}

function setupAmount() {
    const amountSelect = document.getElementById('amountButton');

    // Eventlistener für Änderungen (change) registrieren
    amountSelect.addEventListener('change', function (event) {
        event.preventDefault();
        document.querySelector('.items-wrap').classList.remove('initialized');

        // Den neuen Wert aus dem select-Element holen
        const newAmount = event.target.value;

        const urlParams = new URLSearchParams(window.location.search);
        let paramsStr = urlParams.get('params') || '{}';
        // Entferne die umschließenden geschweiften Klammern
        paramsStr = paramsStr.substring(1, paramsStr.length - 1);

        let paramsObj = {};
        paramsStr.split(',').forEach(pair => {
            let [key, value] = pair.split(':');
            if (key && value) {
                paramsObj[key.trim()] = value.trim();
            }
        });

        // Update: Setze den neuen "amount"-Wert
        paramsObj['amount'] = newAmount;

        // Baue den neuen params-String zusammen
        let newParamsStr = '{' + Object.entries(paramsObj)
            .map(([key, value]) => `${key}:${value}`)
            .join(',') + '}';

        urlParams.set('params', newParamsStr);
        // Lösche eventuelle separate Parameter, falls sie noch vorhanden sind
        urlParams.delete('page');
        urlParams.delete('amount');

        const newUrl = window.location.pathname + '?' + urlParams.toString();

        history.pushState(null, '', newUrl);

        fetch(newUrl)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('#itemsContainer');

                if (newContent) {
                    document.querySelector('#itemsContainer').innerHTML = newContent.innerHTML;
                } else {
                    console.error("Kein neuer Inhalt gefunden!");
                }

                let itemsWrap = document.querySelector('.items-wrap');
                document.body.scrollTop = document.documentElement.scrollTop = 0;
                initItemsList(itemsWrap);
            })
            .catch(error => console.error('Fehler beim Laden der neuen Seite:', error));
    });
}


function generateHomeLink() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.size <= 0) {
        return;
    }

    let imgDiv = document.querySelector('.logo-wrap');
    let imgDivInner = imgDiv.innerHTML;
    let imgA = document.createElement('a');
    imgA.href = '/';
    imgA.classList.add('logo-wrap');
    imgA.innerHTML = imgDivInner;
    imgDiv.parentNode.replaceChild(imgA, imgDiv);
}

function observeToNotificate() {
    let items = document.querySelectorAll('.item-wrap');

    items.forEach(item => {
        let lastTimeEl = item.querySelector('.item-last-time');
        if (lastTimeEl && lastTimeEl.innerHTML.includes('Sekunden')) {
            if (Notification.permission === "granted") {
                let itemText = item.querySelector('.item-heading').innerHTML;
                let now = Date.now();

                if (!lastNotificationTime[itemText] || (now - lastNotificationTime[itemText] > 60000)) {
                    // Sende die Notification nur, wenn noch keine in den letzten 60 Sekunden gesendet wurde.
                    const notification = new Notification("ITEM SOLD", {
                        body: 'iwas wurde verkauft ' + itemText,
                        data: { text: itemText }
                    });

                    // Aktualisiere den Zeitstempel für dieses Item
                    lastNotificationTime[itemText] = now;
                    console.log("ich sende nun!");
                }
            }
        }
    });
}