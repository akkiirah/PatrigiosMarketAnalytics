import { loadCategories } from './categories.js';
import { initItemsList, distributeItems, refreshData, showPriceHistory } from './items.js';
import { setupPagination, setupAmount } from './pagination.js';
import { generateHomeLink } from './homeLink.js';
import { debounce } from './utils.js';

export function initApp() {
    document.addEventListener('DOMContentLoaded', () => {
        const itemsWrap = document.querySelector('.items-wrap');
        const itemsContainer = document.getElementById('itemsContainer');

        loadCategories();

        if (itemsContainer && itemsContainer.classList.contains('list')) {
            initItemsList(itemsWrap);
            setupPagination();
            setupAmount();
        }

        if (itemsContainer && itemsContainer.classList.contains('start')) {
            distributeItems(itemsWrap);
            window.addEventListener('resize', debounce(() => distributeItems(itemsWrap), 100));
            refreshData(5, itemsWrap);
            showPriceHistory();
        }

        Notification.requestPermission();
        generateHomeLink();
    });
}