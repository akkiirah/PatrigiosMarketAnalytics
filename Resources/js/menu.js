export function buildMenu(data) {
    const menuContainer = document.getElementById('menu-categories-content');
    menuContainer.style.opacity = '0';

    for (const mainCatId in data.mainCategories) {
        if (data.mainCategories.hasOwnProperty(mainCatId)) {
            const mainCatName = data.mainCategories[mainCatId];
            const subCats = data.subCategories[mainCatId];
            const menuItem = createMenuItem(mainCatName, mainCatId, subCats);
            menuContainer.appendChild(menuItem);
        }
    }
}

function createMenuItem(mainCatName, mainCatId, subCats) {
    const mainItem = document.createElement('div');
    mainItem.classList.add('main-category-wrap');

    const toggleButton = document.createElement('button');
    toggleButton.classList.add('main-category-button');
    toggleButton.textContent = mainCatName;
    mainItem.appendChild(toggleButton);

    const subMenuDiv = createSubCategoryContainer(subCats, mainCatId);
    mainItem.appendChild(subMenuDiv);

    toggleButton.addEventListener('click', function () {
        toggleSubMenu(subMenuDiv);
    });

    return mainItem;
}

function createSubCategoryContainer(subCats, mainCatId) {
    const subMenuDiv = document.createElement('div');
    subMenuDiv.classList.add('sub-category-wrap');
    subMenuDiv.style.pointerEvents = 'none';

    if (subCats) {
        for (const subCatId in subCats) {
            if (subCats.hasOwnProperty(subCatId)) {
                const subCatName = subCats[subCatId];
                const subItemLink = document.createElement('a');
                subItemLink.classList.add('sub-category-link');
                subItemLink.textContent = subCatName;
                subItemLink.href = '?controller=Item&action=list&page=1&params={category:' + mainCatId + '-' + subCatId + '}';
                subMenuDiv.appendChild(subItemLink);
                subMenuDiv.appendChild(document.createElement('br'));
            }
        }
    }

    return subMenuDiv;
}

function toggleSubMenu(subMenuDiv) {
    if (!subMenuDiv.classList.contains('open')) {
        openSubMenu(subMenuDiv);
    } else {
        closeSubMenu(subMenuDiv);
    }
}

function openSubMenu(subMenuDiv) {
    subMenuDiv.classList.add('open');
    subMenuDiv.style.pointerEvents = 'all';
    subMenuDiv.style.height = '0';
    void subMenuDiv.offsetHeight;
    const fullHeight = subMenuDiv.scrollHeight;
    subMenuDiv.style.height = fullHeight + 'px';

    subMenuDiv.addEventListener('transitionend', function handler(e) {
        if (e.propertyName === 'height') {
            subMenuDiv.style.height = 'auto';
            subMenuDiv.removeEventListener('transitionend', handler);
        }
    });
}

function closeSubMenu(subMenuDiv) {
    subMenuDiv.style.height = subMenuDiv.scrollHeight + 'px';
    void subMenuDiv.offsetHeight;
    subMenuDiv.style.height = '0';

    subMenuDiv.addEventListener('transitionend', function handler(e) {
        if (e.propertyName === 'height') {
            subMenuDiv.classList.remove('open');
            subMenuDiv.style.pointerEvents = 'none';
            subMenuDiv.removeEventListener('transitionend', handler);
        }
    });
}

document.getElementById('menu-categories-button').addEventListener('click', function () {
    const menuContainer = document.getElementById('menu-categories-content');
    document.body.classList.toggle('menu-open');
    menuContainer.classList.toggle('open');

    if (menuContainer.style.opacity === '0') {
        menuContainer.style.opacity = '1';
        menuContainer.style.pointerEvents = 'all';

    } else {
        menuContainer.style.opacity = '0';
        menuContainer.style.pointerEvents = 'none';
    }
});
