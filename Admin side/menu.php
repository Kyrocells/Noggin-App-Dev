<?php

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the current page from the query parameter
$current_page = isset($_GET['page']) ? $_GET['page'] : 'view';
?>

<aside class="sidebar">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <!-- logo -->
            <img src="../img/logo.png" alt="logo">
            <h5 class="offcanvas-title" id="offcanvasLabel">Administrator</h5>
        </div>
        <hr class="my-1">
        <div class="offcanvas-body">
            <!-- buttons -->
            <div class="list-group my-4">
                <a href="index.php?page=view" class="list-group-item list-group-item-action <?php echo $current_page == 'view' ? 'active' : 'not_active'; ?>" aria-current="true">
                    Video Catalog
                </a>
                <a href="index.php?page=add" class="list-group-item list-group-item-action <?php echo $current_page == 'add' ? 'active' : 'not_active'; ?>">Add Video</a>
                <a href="index.php?page=transaction_history" class="list-group-item list-group-item-action <?php echo $current_page == 'transaction_history' ? 'active' : 'not_active'; ?>">Transactions</a>
                <a href="index.php?page=reports" class="list-group-item list-group-item-action <?php echo $current_page == 'reports' ? 'active' : 'not_active'; ?>">Reports</a>
                <a href="logout.php" class="list-group-item list-group-item-action not_active">Logout</a>
            </div>
        </div>
    </div>
</aside>
