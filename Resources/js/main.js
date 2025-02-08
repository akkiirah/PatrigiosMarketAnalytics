window.addEventListener('DOMContentLoaded', function () {
    const itemsWrap = document.querySelector('.items-wrap');

    distributeItems(itemsWrap);
    //refreshPage(60);

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