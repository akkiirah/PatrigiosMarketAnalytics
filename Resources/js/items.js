import { debounce } from './utils.js';
import { observeToNotificate } from './notifications.js';

export function distributeItems(itemsWrap) {
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

    initItemsList(itemsWrap);
}

export function initItemsList(itemsWrap) {
    setTimeout(() => {
        itemsWrap.classList.add('initialized');
    }, 250);
}

export function refreshData(waitInSecs, itemsWrap) {
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

                let newItemsWrap = document.querySelector('.items-wrap');

                distributeItems(newItemsWrap);
                observeToNotificate();

                refreshData(waitInSecs, newItemsWrap);
                window.addEventListener('resize', debounce(() => distributeItems(newItemsWrap), 100));
            })
            .catch(error => console.error('Fehler beim Laden der neuen Seite:', error));
    }, 1000 * waitInSecs);
}
