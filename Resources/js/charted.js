

export function initChart() {
    const priceHistory = JSON.parse(document.getElementById('priceHistory').textContent);

    console.log(priceHistory);

    // Erstelle Arrays für Labels und Daten
    const labels = Object.keys(priceHistory); // Extrahiert die Datumswerte
    const prices = Object.values(priceHistory); // Extrahiert die Preiswerte

    const itemMin = document.querySelector('.item-wrap').getAttribute('data-item-minprice');
    const itemMax = document.querySelector('.item-wrap').getAttribute('data-item-maxprice');
    const itemMinNum = parseInt(itemMin, 10);
    const itemMaxNum = parseInt(itemMax, 10);


    // Farben für Anstieg und Fall
    const lineColor = prices[prices.length - 1] > prices[0] ? '#a6e3a1' : '#f38ba8'; // Anstieg = #a6e3a1, Fall = #f38ba8
    const fillColor = prices[prices.length - 1] > prices[0] ? 'rgba(166, 227, 161, 0.2)' : 'rgba(243, 139, 168, 0.2)'; // Transparente Farben

    // Konfiguriere den Chart
    const config = {
        type: 'line', // Liniendiagramm
        data: {
            labels: labels,
            datasets: [{
                label: 'Preisverlauf',
                data: prices,
                borderColor: lineColor,
                backgroundColor: fillColor,
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointBackgroundColor: fillColor,
                pointBorderColor: fillColor,
                pointRadius: 3,
                pointHoverRadius: 12,
                pointStyle: 'circle'
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Datum'
                    },
                    ticks: {
                        callback: function (value, index) {
                            // Zeige nur jedes 30. Label an
                            if (index % 1 === 0) {
                                return this.getLabelForValue(value);
                            } else {
                                return ''; // Blende alle anderen Labels aus
                            }
                        }
                    },
                    grid: {
                        display: true,
                        color: 'rgba(200, 200, 200, 0.1)'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Preis'
                    },
                    min: itemMinNum,
                    max: itemMaxNum,
                    grid: {
                        display: true,
                        color: 'rgba(200, 200, 200, 0.1)'
                    }
                }

            },
            plugins: {
                zoom: {
                    limits: {
                        y: { min: itemMinNum, max: itemMaxNum }
                    },
                    pan: {
                        enabled: true,
                        mode: 'xy',
                        modifierKey: null
                    },
                    zoom: {
                        wheel: { enabled: true },
                        pinch: { enabled: true },
                        mode: 'xy'
                    }
                }
            }
        }
    };

    // Erstelle den Chart
    const ctx = document.getElementById('preisChart').getContext('2d');
    const preisChart = new Chart(ctx, config);
}
