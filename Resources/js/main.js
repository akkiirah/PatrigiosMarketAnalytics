window.addEventListener('DOMContentLoaded', function () {

    const itemsWrap = document.querySelector('.items-wrap');

    distributeItems(itemsWrap);
    //refreshPage(60);

    loadCategories();


    window.addEventListener('resize', debounce(() => distributeItems(itemsWrap), 100));
});

function distributeItems(itemsWrap) {

    const screenWidth = window.innerWidth;
    let maxColumns;

    if (screenWidth <= 640) maxColumns = 1;
    else if (screenWidth <= 1024) maxColumns = 2;
    else if (screenWidth <= 1500) maxColumns = 3;
    else maxColumns = 4;

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
}

function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function refreshPage(waitInSecs) {
    setTimeout(() => {
        window.location.reload();
    }, (1000 * wait));
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
            console.log('Geladene Kategorien:', data);
            buildMenu(data);
        })
        .catch(error => {
            console.error('Fehler beim Laden der JSON-Datei:', error);
        });
}

function buildMenu(data) {
    const menuContainer = document.getElementById('menu-categories-content');
    menuContainer.style.display = 'none';

    for (const mainCatId in data.mainCategories) {
        if (data.mainCategories.hasOwnProperty(mainCatId)) {
            const mainCatName = data.mainCategories[mainCatId];
            const mainItem = document.createElement('div');
            mainItem.classList.add('main-category-wrap');
            const toggleButton = document.createElement('button');
            toggleButton.classList.add('main-category-button');

            toggleButton.textContent = mainCatName;
            mainItem.appendChild(toggleButton);

            const subMenuDiv = document.createElement('div');
            subMenuDiv.classList.add('sub-category-wrap');
            subMenuDiv.style.display = 'none';

            const subCats = data.subCategories[mainCatId];
            if (subCats) {
                for (const subCatId in subCats) {
                    if (subCats.hasOwnProperty(subCatId)) {
                        const subCatName = subCats[subCatId];

                        const subItemLink = document.createElement('a');
                        subItemLink.textContent = subCatName;
                        subItemLink.href = '?category=' + mainCatId + '-' + subCatId;

                        subMenuDiv.appendChild(subItemLink);
                        subMenuDiv.appendChild(document.createElement('br'));
                    }
                }
            }


            toggleButton.addEventListener('click', function () {
                if (subMenuDiv.style.display === 'none') {
                    subMenuDiv.style.display = 'block';
                } else {
                    subMenuDiv.style.display = 'none';
                }
            });

            mainItem.appendChild(subMenuDiv);
            menuContainer.appendChild(mainItem);
        }
    }
}

document.getElementById('menu-categories-button').addEventListener('click', function () {
    const menuContainer = document.getElementById('menu-categories-content');

    if (menuContainer.style.display == 'none') {
        menuContainer.style.display = 'grid';
    } else {
        menuContainer.style.display = 'none';
    }
});