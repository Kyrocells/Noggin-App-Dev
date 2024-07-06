<div class="container movie_container">
    <!-- navbar -->
    <nav class="navbar my-4">
        <!-- dropdown filter -->
        <div class="dropdown">
            <button class="filter_button mx-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Filter
            </button>
            <ul class="dropdown-menu" id="genre-filter">
                <li><a class="dropdown-item" href="#" data-genre="all">All Videos</a></li>
                <li><a class="dropdown-item" href="#" data-genre="rented">Currently Rented</a></li>
                <li><a class="dropdown-item" href="#" data-genre="returned">Returned</a></li>
            </ul>
        </div>
        <form class="form-inline mb-0 searchbar">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="search_button mx-2" type="submit">Search</button>
        </form>
    </nav>
    
    <!-- display -->
    <h2 class="genre-heading" data-genre="rented">Currently Rented</h2>
        <div class="scrolling-container">
            <div class="row mb-2 genre-row" data-genre="rented">
                <div class="card movie_card">
                    <img src="path/to/image1.jpg" class="card-img-top movie_img" alt="movie picture">
                    <div class="card-body">
                        <h5 class="card-title">Movie 1</h5>
                    </div>
                    <div class="additional-content">
                        <a href="#" class="movie_card_button">Return</a>
                    </div>
                </div>
                <div class="card movie_card">
                    <img src="path/to/image2.jpg" class="card-img-top movie_img" alt="movie picture">
                    <div class="card-body">
                        <h5 class="card-title">Movie 2</h5>
                    </div>
                    <div class="additional-content">
                        <a href="#" class="movie_card_button">Return</a>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="genre-heading" data-genre="returned">Returned</h2>
        <div class="scrolling-container">
            <div class="row mb-2 genre-row" data-genre="returned">
                <div class="card movie_card">
                    <img src="path/to/image3.jpg" class="card-img-top movie_img" alt="movie picture">
                    <div class="card-body">
                        <h5 class="card-title">Movie 3</h5>
                    </div>
                    <div class="additional-content">
                        <a href="#" class="movie_card_button mb-2">View</a>
                    </div>
                </div>
                <div class="card movie_card">
                    <img src="path/to/image4.jpg" class="card-img-top movie_img" alt="movie picture">
                    <div class="card-body">
                        <h5 class="card-title">Movie 4</h5>
                    </div>
                    <div class="additional-content">
                        <a href="#" class="movie_card_button mb-2">View</a>
                    </div>
                </div>
            </div>
        </div>

<!-- script to be added after db is fixed and shz -->
<script></script>





