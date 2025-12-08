// Graphiques d'évolution des notes par module
// Les données doivent être passées via une variable globale ou un élément data-
// Pour l'instant, nous allons supposer que donneesGraphiqueEvolution est accessible globalement ou passé via un script inline
// Il est préférable de passer des données via un script inline dans le Blade et de les rendre disponibles ici.

// Exemple de comment les données seraient passées dans le Blade :
// <script>
//     window.donneesGraphiqueEvolution = @json($donneesGraphiqueEvolution);
// </script>

document.addEventListener('DOMContentLoaded', function() {
    if (typeof window.donneesGraphiqueEvolution !== 'undefined' && window.donneesGraphiqueEvolution !== null) {
        const donneesGraphiqueEvolution = window.donneesGraphiqueEvolution;

        for (const moduleLibelle in donneesGraphiqueEvolution) {
            if (donneesGraphiqueEvolution.hasOwnProperty(moduleLibelle)) {
                const data = donneesGraphiqueEvolution[moduleLibelle];
                const labels = data.map(item => item.date_evaluation);
                const moyennes = data.map(item => item.moyenne);

                // Remplacer les caractères spéciaux pour l'ID du canvas
                const canvasId = `chartEvolution${moduleLibelle.toLowerCase().replace(/[^a-z0-9]+/g, '-')}`;
                const ctx = document.getElementById(canvasId);
                
                if (ctx) {
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Moyenne des notes',
                                data: moyennes,
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1,
                                fill: false
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    max: 20
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }
            }
        }
    }
});
