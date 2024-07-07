<?php
require_once 'functions.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Connect to the database
$conn = dbConnect();

// not yet returned = 0
$sql = "
    SELECT rv.video_id, rv.video_format, v.image, v.video_title
    FROM rented_videos rv
    JOIN videos v ON rv.video_id = v.video_id
    WHERE rv.user_id = ? AND rv.returned = 0
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$rented_videos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// returned = 1
$sql = "
    SELECT rv.video_id, rv.video_format, v.image, v.video_title
    FROM rented_videos rv
    JOIN videos v ON rv.video_id = v.video_id
    WHERE rv.user_id = ? AND rv.returned = 1
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$returned_videos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

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
            <?php if (empty($rented_videos)): ?>
                <p class="no_videos"><strong>No videos available.</strong></p>
            <?php else: ?>
                <?php foreach ($rented_videos as $video): ?>
                    <div class="card movie_card mb-4">
                        <img src="<?php echo htmlspecialchars($video['image']); ?>" class="card-img-top movie_img" alt="movie picture">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($video['video_title']); ?></h5>
                            <h5 class="card-title"><strong>Format:</strong> <?php echo htmlspecialchars($video['video_format']); ?></h5>
                        </div>
                        <div class="additional-content">
                            <a href="process_return.php?video_id=<?php echo $video['video_id']; ?>&video_format=<?php echo urlencode($video['video_format']); ?>" class="movie_card_button" id="return_confirm">Return</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <h2 class="genre-heading" data-genre="returned">Returned</h2>
    <div class="scrolling-container">
        <div class="row mb-2 genre-row" data-genre="returned">
            <?php if (empty($returned_videos)): ?>
                <p class="no_videos"><strong>No videos available.</strong></p>
            <?php else: ?>
                <?php foreach ($returned_videos as $video): ?>
                    <div class="card movie_card">
                        <img src="<?php echo htmlspecialchars($video['image']); ?>" class="card-img-top movie_img" alt="movie picture">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($video['video_title']); ?></h5>
                            <p><strong>Format:</strong> <?php echo htmlspecialchars($video['video_format']); ?></p>
                        </div>
                        <div class="additional-content">
                            <a href="index.php?page=single_return&video_id=<?php echo $video['video_id']; ?>&video_format=<?php echo urlencode($video['video_format']); ?>" class="movie_card_button mb-2">View</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- confirmation pop up here -->
<div id="confirm_return" class="pop_up_confirmation_modal">
    <div class="pop_up_confirmation">
        <p>Are you sure you want to return this video?</p>
        <div class="pop_up_buttons">
            <button id="confirm_the_return" class="back_button mx-2">Yes</button>
            <button id="cancel_the_return" class="back_button mx-2">No</button>
        </div>
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


    // this is for the ano, anonas, the pop up
    document.addEventListener('DOMContentLoaded', function() {
    
    var modal = document.getElementById('confirm_return');
    var conf = document.getElementById('confirm_the_return');
    var cancel = document.getElementById('cancel_the_return');

    
    document.querySelectorAll('#return_confirm').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var returnUrl = this.href;

            modal.style.display = 'block';

            conf.onclick = function() {
                window.location.href = returnUrl;
            };

            cancel.onclick = function() {
                modal.style.display = 'none';
            };
        });
    });

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    };
});
</script>
