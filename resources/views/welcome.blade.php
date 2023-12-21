<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>

<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">

        <div class="container m-4">
            <div class="row">
                <div class="col">
                    <h1>Dashboard</h1>
                </div>
            </div>

            <div class="row my-4">
                <div class="col-12">
                    <h2>Top 10 de productos (mas mencionados)</h2>
                </div>
                <div class="col">
                    <canvas id="myChart"></canvas>
                </div>
            </div>

            <div class="row my-4">
                <div class="col-12">
                    <h2>Calif. promedio / Fecha (ultimos 10 dias)</h2>
                </div>
                <div class="col">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('myChart');
        let productos = @json($productos);

        const productosTop10 = Object.entries(productos)
            .sort((a, b) => b[1] - a[1]) // Ordena por cantidad (mayor a menor)
            .slice(0, 11) // Toma los primeros 10 elementos
            .reduce((acc, curr, i) => {
                if (i < 11) {
                    acc[curr[0]] = curr[1];
                }
                return acc;
            }, {}); // Crea un nuevo objeto con los primeros 10 elementos

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(productosTop10),
                datasets: [{
                    label: '# menciones',
                    data: Object.values(productosTop10),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        let fechas = @json($fechas);

        const ctx2 = document.getElementById('myChart2');
        const data = {
            labels: Object.keys(fechas),
            datasets: [{
                type: 'line',
                label: 'Calificacion por fecha',
                data: Object.values(fechas),
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)'
            }, {
                type: 'line',
                label: 'Calificacion promedio',
                data: [50, 50, 50, 50, 50, 50, 50, 50, 50, 50],
                fill: false,
                borderColor: 'rgb(54, 100, 255)'
            }]
        };

        new Chart(ctx2, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>

</html>