export function initChart() {
    const priceHistory = JSON.parse(document.getElementById('priceHistory').textContent);

    console.log(priceHistory);

    // Erstelle Arrays für Labels und Daten
    const labels = Object.keys(priceHistory); // Extrahiert die Datumswerte
    const prices = Object.values(priceHistory); // Extrahiert die Preiswerte

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
                pointHoverRadius: 5,
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
                            if (index % 4 === 0) {
                                return this.getLabelForValue(value);
                            } else {
                                return ''; // Blende alle anderen Labels aus
                            }
                        }
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Preis'
                    }
                }
            }
        }
    };

    // Erstelle den Chart
    const ctx = document.getElementById('preisChart').getContext('2d');
    const preisChart = new Chart(ctx, config);
}
