<?php
require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Rental System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="admin_style.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"> -->
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="wrapper">
        <!-- include the menu -->
        <?php include_once 'menu.php'; ?>
    </div>

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <?php
                $page = $_GET['page'] ?? 'home'; //idk wtf this is nasa code ni sir
                // Default to home page if no specific page request
                switch ($page) {
                    case 'add':
                        include 'add.php';
                        break;
                    case 'edit':
                        include 'edit.php';
                        break;
                    case 'delete':
                        include 'delete.php';
                        break;
                    case 'view':
                        include 'view.php';
                        break;
                    case 'transaction_history':
                        include 'transaction_history.php';
                        break;
                    //uncomment if available na
                    // case 'reports':
                    //     include 'reports.php';
                    //     break;
                    default:
                        include 'view.php';
                        break;
                }
                ?>
            </div>
        </section>
    </div>
    <!-- Main Footer -->
    <!-- <footer class="main-footer">
        <strong>2024 WHALE</strong>
        All rights reserved. For Educational Purposes Only.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer> -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    async function fetchData(url) {
        const response = await fetch(url);
        return response.json();
    }

    async function init() {
        const videoData = await fetchData('http://localhost/TW21/Project/videos_data.php'); // Update with the correct path
        const doughnutConfig = {
            type: 'doughnut',
            data: {
                labels: videoData.map(item => item.video_title),
                datasets: [{
                    data: videoData.map(item => item.num_videos_available),
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(75, 192, 192)',
                        'rgb(255, 205, 86)',
                        'rgb(201, 203, 207)',
                        'rgb(54, 162, 235)'
                    ]
                }]
            }
        };

        const ctx1 = document.getElementById('myChart').getContext('2d');
        new Chart(ctx1, doughnutConfig);
    }

    window.onload = init;
</script>
</body>
</html>
