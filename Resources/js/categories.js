import { buildMenu } from './menu.js';

export function loadCategories() {
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
