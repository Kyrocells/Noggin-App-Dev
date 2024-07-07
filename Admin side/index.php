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
                    //uncomment if available na
                    // case 'transactions':
                    //     include 'transactions.php';
                    //     break;
                    //uncomment if available na
                     case 'reports':
                        include 'reports.php';
                        break;
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
</body>
</html>
