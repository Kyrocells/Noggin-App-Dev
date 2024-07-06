<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Video Rental System</title>
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
                    case 'rent':
                        include 'rent.php';
                        break;
                    case 'rent_history':
                        include 'rent_history.php';
                        break;
                    case 'rent_payment':
                        include 'rent_payment.php';
                        break;
                    case 'notifications':
                        include 'notifications.php';
                        break;
                    case 'single_view':
                        include 'single_view.php';
                        break;
                    case 'profile':
                        include 'profile.php';
                        break;
                    // case 'logout':
                    //     include 'logout.php';
                    //     break;
                    default:
                        include 'rent.php';
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
</body>
</html>
