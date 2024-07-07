<aside class="sidebar">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <!-- logo --><!-- put in from db -->
        <img src="img/logo.png" alt="logo">
        <h5 class="offcanvas-title" id="offcanvasLabel">Video Rental</h5>
    </div>
    <hr class="my-1">
    <div class="offcanvas-body">
        <!-- profile --><!-- put in from db --><!-- default picture -->
        <div class="card my-4 menu_card" style="width: 16rem;">
            <img src="img/alonso.png" class="card-img-top" alt="profile picture">
            <div class="card-body">
            <p class="card-text username"  name="username">Admin</p>
            </div>
        </div>
        <!-- buttons --><!-- put in links to redirect -->
        <div class="list-group my-4">
            <a href="index.php?page=view" class="list-group-item list-group-item-action active" aria-current="true">
                Video Catalog
            </a>
            <a href="index.php?page=add" class="list-group-item list-group-item-action not_active">Add Video</a>
            <a href="index.php?page=#" class="list-group-item list-group-item-action not_active">Transactions</a><!--change # to page name ONLY without filetype-->
            <a href="index.php?page=reports" class="list-group-item list-group-item-action not_active">Reports</a><!--change # to page name ONLY without filetype-->
            <a href="index.php?page=" class="list-group-item list-group-item-action not_active">Logout</a> <!--idk pano sa logout-->
        </div>
    </div>
    </div>
</aside>
