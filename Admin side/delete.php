<?php
require_once 'functions.php';
// Assumes this contains functions like getVideoById() and deleteVideo()

// Function to set session alerts
function setAlert($message, $type = 'success') {
    $_SESSION['alert'] = ['message' => $message, 'type' => $type];
}

// Check if a valid video ID is passed and deletion has not yet been confirmed
if (isset($_GET['id']) && !isset($_GET['confirm'])) {
    $videoId = htmlspecialchars($_GET['id']);
    $video = getVideoById($videoId); // Retrieve video details

    if ($video) {
     //   include 'header.php'; // Include your header file
?>
        <div class="container edit_container">
            <div class="card edit_card">
        <div class="card-header">
            <h3 class="card-title">Delete Video</h3>
            <p class="card-title">Are you sure you want to delete this video?</p>
        </div>
        <form action="index.php?page=edit&id=<?php echo $video['video_id']; ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label>Title</label>
                            <input type="text" class="form-control" name="video_title" value="<?php echo htmlspecialchars($video['video_title']); ?>" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="genre">Genre</label>
                            <select class="form-control" name="genre" id="genreSelect" disabled>
                                <option value="Action" <?php if ($video['genre'] === 'Action') echo 'selected'; ?>>Action</option>
                                <option value="Comedy" <?php if ($video['genre'] === 'Comedy') echo 'selected'; ?>>Comedy</option>
                                <option value="Drama" <?php if ($video['genre'] === 'Drama') echo 'selected'; ?>>Drama</option>
                                <option value="Fantasy" <?php if ($video['genre'] === 'Fantasy') echo 'selected'; ?>>Fantasy</option>
                                <option value="Horror" <?php if ($video['genre'] === 'Horror') echo 'selected'; ?>>Horror</option>
                                <!-- Add more options as needed -->
                            </select>
                            <!--  -->
                            <input type="hidden" name="genre" value="<?php echo htmlspecialchars($video['genre']); ?>">
                        </div>
                        <div class="form-group mt-3">
                            <label>Release Year</label>
                            <input type="number" class="form-control" name="release_date" value="<?php echo htmlspecialchars($video['release_date']); ?>" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label>Copies</label>
                            <input type="number" class="form-control" name="num_videos_available" value="<?php echo htmlspecialchars($video['num_videos_available']); ?>" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="actors">Actors</label>
                            <input type="text" class="form-control" name="actors" value="<?php echo htmlspecialchars($video['actors']); ?>" placeholder="Enter actors" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="desc">Description</label>
                            <textarea type="text" class="form-control" name="desc" rows="5" placeholder="Enter description" readonly><?php echo htmlspecialchars($video['description']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="video_format">Video Format</label><br>
                            <input type="radio" id="dvd" name="video_format" value="DVD" <?php if ($video['video_format'] === 'DVD') echo 'checked'; ?> disabled>
                            <label for="dvd">DVD</label><br>
                            <input type="radio" id="bluray" name="video_format" value="Blu-ray" <?php if ($video['video_format'] === 'Blu-ray') echo 'checked'; ?> disabled>
                            <label for="bluray">Blu-ray</label><br>
                            <input type="radio" id="digital" name="video_format" value="Digital" <?php if ($video['video_format'] === 'Digital') echo 'checked'; ?> disabled>
                            <label for="digital">Digital</label><br>
                            <!-- -->
                            <input type="hidden" name="video_format" value="<?php echo htmlspecialchars($video['video_format']); ?>">
                        </div>
                        <div class="form-group mt-3">
                            <label for="rental_fee">Rental Fee</label>
                            <input type="number" step="0.01" class="form-control" name="rental_fee" value="<?php echo htmlspecialchars($video['rental_fee']); ?>" readonly>
                        </div>
                        <div class="form-group mt-3">
                            <label for="length">Length</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" class="form-control" name="hours" value="<?php echo floor($video['length'] / 3600); ?>" placeholder="Hours" readonly>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="minutes" value="<?php echo floor(($video['length'] % 3600) / 60); ?>" placeholder="Minutes" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
            <div class="card-footer">
                <a href="delete.php?confirm=yes&id=<?= $videoId; ?>" class="btn admin_button mx-2">Delete</a>
                <a href="index.php?page=view" class="btn admin_button mx-2">Cancel</a>
            </div>
        </div>
<?php

    } else {
        setAlert("Video not found.", "danger");
        header('Location: index.php?page=view');
        exit();
    }
} elseif (isset($_GET['confirm']) && $_GET['confirm'] == 'yes' && isset($_GET['id'])) {
    // Confirm deletion
    if (deleteVideo($_GET['id'])) {
        setAlert('Video deleted successfully.', 'success');
    } else {
        setAlert('Failed to delete video. Video not found.', 'danger');
    }
    header('Location: index.php?page=view'); // Redirect to the video list page
    exit();
} else {
    // No ID was provided
    setAlert('No video ID specified.', 'danger');
    header('Location: index.php?page=view');
    exit();
}
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var genreSelect = document.getElementById('genreSelect');
    genreSelect.addEventListener('click', function(event) {
        event.preventDefault();
        return false;
    });
});
</script>


