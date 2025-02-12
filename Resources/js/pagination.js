export function setupPagination() {
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
                    setTimeout(() => {
                        itemsWrap.classList.add('initialized');
                    }, 250);
                })
                .catch(error => console.error('Fehler beim Laden der neuen Seite:', error));
        }
    });
}

export function setupAmount() {
    const amountSelect = document.getElementById('amountButton');

    amountSelect.addEventListener('change', function (event) {
        event.preventDefault();
        document.querySelector('.items-wrap').classList.remove('initialized');

        const newAmount = event.target.value;
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

        paramsObj['amount'] = newAmount;

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
                setTimeout(() => {
                    itemsWrap.classList.add('initialized');
                }, 250);
            })
            .catch(error => console.error('Fehler beim Laden der neuen Seite:', error));
    });
}
