<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Rental System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="wrapper">
        <!-- Include the menu -->
        <?php include_once 'menu.php'; ?>
    </div>

    <!-- Chart Container -->
    <div class="chartContainer">
        <h1 class="mt-5">Line Chart - Total Videos Available per Month</h1>
        <canvas id="myChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        async function fetchData(url) {
            const response = await fetch(url);
            return response.json();
        }

        async function init() {
            try {
                const videoData = await fetchData('videos_data.php');
                console.log('Fetched data:', videoData);

                const labels = videoData.map(item => item.month_year);
                const data = videoData.map(item => item.total_sold);

                const lineConfig = {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Total Videos Available',
                            data: data,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Total Videos Available'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            }
                        }
                    }
                };

                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, lineConfig);
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }

        window.onload = init;
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>

</body>
</html>
