document.addEventListener("DOMContentLoaded", function () {
    // ------- GRÁFICA 1: PROMEDIO POR MATERIA (BARRAS) -------
    const ctxPromedio = document.getElementById('graficaPromedio');

    if (ctxPromedio) {
        // Datos de ejemplo (luego se llenan desde PHP/BD)
        const labelsMaterias = ['Matemáticas', 'Español', 'Química', 'Física', 'Prog. Web'];
        const promedios = [8.5, 9.2, 7.8, 8.9, 9.5];

        new Chart(ctxPromedio, {
            type: 'bar',
            data: {
                labels: labelsMaterias,
                datasets: [{
                    label: 'Promedio',
                    data: promedios,
                    borderWidth: 1,
                    backgroundColor: [
                        '#6FA8FF',
                        '#FF9BBF',
                        '#FFB48A',
                        '#5146D9',
                        '#1A1C2D'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                        ticks: {
                            stepSize: 1
                        }
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

    // ------- GRÁFICA 2: TAREAS SEMANALES (COMPLETADAS vs PENDIENTES) -------
    const ctxTareas = document.getElementById('graficaTareas');

    if (ctxTareas) {
        // Datos de ejemplo (luego se llenan dinámicamente)
        const completadas = 7;
        const pendientes = 3;

        new Chart(ctxTareas, {
            type: 'doughnut',
            data: {
                labels: ['Completadas', 'Pendientes'],
                datasets: [{
                    data: [completadas, pendientes],
                    backgroundColor: ['#6FA8FF', '#FF9BBF'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                cutout: '60%'
            }
        });
    }

    // ------- TOAST DE BIENVENIDA (si APP existe) -------
    if (window.APP && typeof APP.showToast === "function") {
        APP.showToast("Bienvenido a tu panel, ¡vamos a estudiar! 📚", "info", 4500);
    }
});


