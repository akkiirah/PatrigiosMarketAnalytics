import { loadCategories } from './categories.js';
import { initItemsList, distributeItems, refreshData, showPriceHistory } from './items.js';
import { setupPagination, setupAmount } from './pagination.js';
import { generateHomeLink } from './homeLink.js';
import { debounce } from './utils.js';
import { initChart } from './charted.js';
import { loginRegister } from './user.js';
import { toggleFavoriteItem } from './favorites.js';

export function initApp() {
    document.addEventListener('DOMContentLoaded', () => {
        const itemsWrap = document.querySelector('.items-wrap');
        const itemsContainer = document.getElementById('itemsContainer');

        loadCategories();


        if (itemsContainer && itemsContainer.classList.contains('list')) {
            initItemsList(itemsWrap);
            setupPagination();
            setupAmount();
            toggleFavoriteItem();
        }

        if (itemsContainer && itemsContainer.classList.contains('detail')) {
            initChart();
        }

        if (document.querySelector('.input-login') || document.querySelector('.input-register')) {
            loginRegister();
        }

        if (itemsContainer && itemsContainer.classList.contains('start')) {
            distributeItems(itemsWrap);
            window.addEventListener('resize', debounce(() => distributeItems(itemsWrap), 100));
            refreshData(10, itemsWrap);
            showPriceHistory();
            toggleFavoriteItem();
        }

        Notification.requestPermission();
        generateHomeLink();
    });
}