<?php
session_start();
include_once 'functions.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user = getUserProfile($user_id);
} else {
    header('Location: login.php');
    exit();
}

//check if what page ang active
$current_page = isset($_GET['page']) ? $_GET['page'] : 'rent';
?>

<aside class="sidebar">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasLabel">
        <div class="offcanvas-header">
            <!-- logo -->
            <img src="../img/logo.png" alt="logo">
            <h5 class="offcanvas-title" id="offcanvasLabel">Video Rental</h5>
        </div>
        <hr class="my-1">
        <div class="offcanvas-body">
            <!-- profile -->
            <div class="card my-4 menu_card" style="width: 16rem;">
                <img src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : '../img/russell.png'; ?>" class="card-img-top" alt="profile picture">
                <div class="card-body">
                    <p class="card-text username"><?php echo htmlspecialchars($user['username']); ?></p>
                </div>
            </div>
            <!-- buttons -->
            <div class="list-group my-4">
                <a href="index.php?page=rent" class="list-group-item list-group-item-action <?php echo $current_page == 'rent' ? 'active' : 'not_active'; ?>" aria-current="true">
                    Rent
                </a>
                <a href="index.php?page=rent_history" class="list-group-item list-group-item-action <?php echo $current_page == 'rent_history' ? 'active' : 'not_active'; ?>">Rent History</a>
                <a href="index.php?page=profile" class="list-group-item list-group-item-action <?php echo $current_page == 'profile' ? 'active' : 'not_active'; ?>">Profile</a>
                <a href="logout.php" class="list-group-item list-group-item-action not_active">Logout</a>
            </div>
        </div>
    </div>
</aside>
