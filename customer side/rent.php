<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli('localhost', 'root', '', 'video_rental_noggin');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the SQL query to select the video_title
$sql = "SELECT image, genre, video_title FROM videos ORDER BY genre";
$result = $conn->query($sql);

$movies_by_genre = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $genre = $row['genre'];
        $image = $row['image'];
        $video_title = $row['video_title'];

        if (!isset($movies_by_genre[$genre])) {
            $movies_by_genre[$genre] = array();
        }
        $movies_by_genre[$genre][] = array('image' => $image, 'video_title' => $video_title);
    }
}

$conn->close();
?>

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
                <li><a class="dropdown-item" href="#" data-genre="Action">Action</a></li>
                <li><a class="dropdown-item" href="#" data-genre="Drama">Drama</a></li>
                <li><a class="dropdown-item" href="#" data-genre="Comedy">Comedy</a></li>
                <li><a class="dropdown-item" href="#" data-genre="Fantasy">Fantasy</a></li>
                <li><a class="dropdown-item" href="#" data-genre="Horror">Horror</a></li>
            </ul>
        </div>
        <form class="form-inline mb-0 searchbar">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search">
            <button class="search_button mx-2" type="submit">Search</button>
        </form>
    </nav>
    
    <!-- display -->
    <div id="movies-display">
        <?php
        $movies_found = false;

        foreach ($movies_by_genre as $genre => $movies) {
            if (!empty($movies)) {
                $movies_found = true;

                echo '<h2 class="genre-heading" data-genre="' . $genre . '">' . $genre . '</h2>';
                echo '<div class="scrolling-container">';
                echo '<div class="row mb-2 genre-row" data-genre="' . $genre . '">';
                
                foreach ($movies as $movie) {
                    echo '<div class="card movie_card">';
                    echo '<img src="' . $movie['image'] . '" class="card-img-top movie_img" alt="movie picture">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $movie['video_title'] . '</h5>';
                    echo '</div>';
                    echo '<div class="additional-content">';
                    echo '<a href="#" class="movie_card_button mb-2">View</a>';
                    echo '<a href="#" class="movie_card_button">Rent</a>';
                    echo '</div></div>';
                }
                
                echo '</div></div>'; 
            }
        }

        // pag no videos
        if (!$movies_found) {
            echo '<p class="no_videos">No videos available.</p>';
        }
        ?>
    </div>
</div>

<!-- pang show and no show ng videos per category using filter-->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filter = document.querySelectorAll('#genre-filter .dropdown-item');
        const genre_title = document.querySelectorAll('.genre-heading');
        const genres = document.querySelectorAll('.genre-row');

        filter.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const selectedGenre = this.getAttribute('data-genre');

                genre_title.forEach(heading => {
                    if (selectedGenre === 'all' || heading.getAttribute('data-genre') === selectedGenre) {
                        heading.style.display = 'block';
                    } else {
                        heading.style.display = 'none';
                    }
                });

                genres.forEach(row => {
                    if (selectedGenre === 'all' || row.getAttribute('data-genre') === selectedGenre) {
                        row.style.display = 'flex';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
