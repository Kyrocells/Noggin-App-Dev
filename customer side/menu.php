<aside class="sidebar">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <!-- logo -->
        <!-- put in src -->
        <img src="img/logo.png" alt="logo">
        <h5 class="offcanvas-title" id="offcanvasLabel">Video Rental</h5>
    </div>
    <hr class="my-1">
    <div class="offcanvas-body">
        <!-- profile -->
        <!-- put in src; default picture -->
        <div class="card my-4 menu_card" style="width: 16rem;">
            <img src="img/russell.png" class="card-img-top" alt="profile picture">
            <div class="card-body">
            <p class="card-text username"  name="username">Username</p>
            </div>
        </div>
        <!-- buttons -->
        <!-- put in links to redirect -->
        <div class="list-group my-4">
            <a href="index.php?page=rent" class="list-group-item list-group-item-action active" aria-current="true">
                Rent
            </a>
            <a href="index.php?page=rent_history" class="list-group-item list-group-item-action not_active">Rent History</a>
            <a href="index.php?page=return" class="list-group-item list-group-item-action not_active">Return</a>
            <a href="index.php?page=notifications" class="list-group-item list-group-item-action not_active">Notifications</a>
            <a href="index.php?page=profile" class="list-group-item list-group-item-action not_active">Profile</a>
            <a href="index.php?page=" class="list-group-item list-group-item-action not_active">Logout</a> <!--idk pano sa logout-->
        </div>
    </div>
    </div>
</aside>