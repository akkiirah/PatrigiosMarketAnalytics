import { debounce } from './utils.js';
import { observeToNotificate } from './notifications.js';

export function distributeItems(itemsWrap) {
    const screenWidth = window.innerWidth;
    let maxColumns;

    if (screenWidth <= 1024) maxColumns = 1;
    else if (screenWidth <= 1500) maxColumns = 2;
    else maxColumns = 3;

    const items = Array.from(itemsWrap.querySelectorAll('.item-wrap'));

    if (items.length === 0) {
        return;
    }

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

function startProgressBar(waitTime) {
    const startTime = Date.now();
    function update() {
        const elapsed = Date.now() - startTime;
        const progress = Math.min((elapsed / waitTime) * 100, 100);
        document.body.style.setProperty('--progress', progress + '%');
        if (progress < 100) {
            requestAnimationFrame(update);
        }
    }
    update();
}

export function refreshData(waitInSecs) {
    const waitTime = waitInSecs * 1000;

    startProgressBar(waitTime);

    setTimeout(() => {
        const expandedItems = [];
        document.querySelectorAll('.price-button.expanded').forEach(btn => {
            const id = btn.getAttribute('data-id');
            if (id) {
                expandedItems.push(id);
            }
        });

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

                expandedItems.forEach(id => {
                    const btn = document.querySelector(`.price-button[data-id="${id}"]`);
                    if (btn) {
                        btn.classList.add('expanded');
                        const priceWrap = btn.parentElement.nextElementSibling;
                        if (priceWrap) {
                            priceWrap.classList.add('expanded');
                        }
                    }
                });

                document.body.style.setProperty('--progress', '0%');

                refreshData(waitInSecs);
                window.addEventListener('resize', debounce(() => distributeItems(newItemsWrap), 100));
            })
            .catch(error => console.error('Fehler beim Laden der neuen Seite:', error));
    }, waitTime);
}


export function showPriceHistory() {
    document.addEventListener("click", (event) => {
        // Suche in der Event-Pfad-Kette nach dem Element mit der ID priceButton
        const button = event.target.closest('.price-button');
        if (button) {
            event.preventDefault(); // Verhindert das Navigieren des übergeordneten Links
            event.stopPropagation(); // Verhindert das Weiterreichen des Events

            button.classList.toggle('expanded');
            const priceWrap = button.parentElement.nextElementSibling;
            if (priceWrap) {
                priceWrap.classList.toggle('expanded');
            }
        }
    });
}

