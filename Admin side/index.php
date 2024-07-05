<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['alert'])) {
    $_SESSION['alert'] = null;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
if (!isset($_SESSION['videos'])) {
    $_SESSION['videos'] = array(); 
    // Initialize videos session array if not already set
}
require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Rental System</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <!-- Navbar -->
    <?php include 'menu.php'; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <?php
                $page = $_GET['page'] ?? 'home';
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
                    case 'payment':
                        include 'payment.php';
                        break;
                    case 'view_single':
                        include 'view_single.php';
                        break;
                    default:
                        echo '<div class="alert alert-info">Welcome to the Video Rental System!</div>';
                        break;
                }
                ?>
                <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="chart-container" style="position: relative; height:40vh; width:80vw">
                    <canvas id="myLineChart"></canvas>
                </div>
            </div>
        </section>
    </div>
    
    <footer class="main-footer">
        <strong>&copy; 2023 Your Company.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.2.0
        </div>
    </footer>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
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