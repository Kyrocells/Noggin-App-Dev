<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (isset($_GET['id'])) {
        $video_id = $_GET['id'];
        $video_title = isset($_POST['video_title']) ? $_POST['video_title'] : '';
        $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
        $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : '';
        $dvdCopies = isset($_POST['dvdCopies']) ? $_POST['dvdCopies'] : 0;
        $blurayCopies = isset($_POST['blurayCopies']) ? $_POST['blurayCopies'] : 0;
        $digitalFormat = isset($_POST['digitalFormat']) ? $_POST['digitalFormat'] : 'No';
        $rental_fee = isset($_POST['rental_fee']) ? $_POST['rental_fee'] : '';
        $hours = isset($_POST['hours']) ? $_POST['hours'] : '';
        $minutes = isset($_POST['minutes']) ? $_POST['minutes'] : '';
        $actors = isset($_POST['actors']) ? $_POST['actors'] : '';
        $desc = isset($_POST['desc']) ? $_POST['desc'] : '';

        // Image upload handling
        if (isset($_FILES['Image']) && $_FILES['Image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['Image'];
        } else {
            $image = null; // No new image uploaded
        }

        editVideo($video_id, $video_title, $genre, $release_date,
            $dvdCopies, $blurayCopies, $digitalFormat, $rental_fee, $hours, $minutes, $actors, $desc, $image);

        echo '<div class="alert alert-success">Video updated successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">No video ID specified.</div>';
    }
}

if (isset($_GET['id'])) {
    $video = getVideoById($_GET['id']);
    if ($video !== null) {
        // Split the length into hours and minutes
        list($hours, $minutes) = explode(':', $video['length']);
?>

<div class="container edit_container">
    <div class="card edit_card">
        <div class="card-header">
            <h3 class="card-title">Edit Video</h3>
        </div>
        <form action="index.php?page=edit&id=<?php echo $video['video_id']; ?>" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label>Title</label>
                            <input type="text" class="form-control" name="video_title" value="<?php echo htmlspecialchars($video['video_title']); ?>" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="genre">Genre</label>
                            <select class="form-control" name="genre" required>
                                <option value="">Select genre</option>
                                <option value="Action" <?php if ($video['genre'] === 'Action') echo 'selected'; ?>>Action</option>
                                <option value="Comedy" <?php if ($video['genre'] === 'Comedy') echo 'selected'; ?>>Comedy</option>
                                <option value="Drama" <?php if ($video['genre'] === 'Drama') echo 'selected'; ?>>Drama</option>
                                <option value="Fantasy" <?php if ($video['genre'] === 'Fantasy') echo 'selected'; ?>>Fantasy</option>
                                <option value="Horror" <?php if ($video['genre'] === 'Horror') echo 'selected'; ?>>Horror</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label>Release Year</label>
                            <input type="number" class="form-control" name="release_date" value="<?php echo htmlspecialchars($video['release_date']); ?>" min="0" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="dvdCopies">DVD Copies</label>
                            <input type="number" class="form-control" name="dvdCopies" value="<?php echo htmlspecialchars($video['dvd_stocks']); ?>" min="0" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="blurayCopies">Blu-ray Copies</label>
                            <input type="number" class="form-control" name="blurayCopies" value="<?php echo htmlspecialchars($video['bray_stocks']); ?>" min="0" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="digitalFormat">Digital Format</label><br>
                            <input type="radio" id="digitalYes" name="digitalFormat" value="Yes" <?php if ($video['digital'] == 1) echo 'checked'; ?> required>
                            <label for="digitalYes">Yes</label><br>
                            <input type="radio" id="digitalNo" name="digitalFormat" value="No" <?php if ($video['digital'] == 0) echo 'checked'; ?> required>
                            <label for="digitalNo">No</label><br>
                        </div>
                        <div class="form-group mt-3">
                            <label for="actors">Actors</label>
                            <input type="text" class="form-control" name="actors" value="<?php echo htmlspecialchars($video['actors']); ?>" placeholder="Enter actors" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="desc">Description</label>
                            <textarea type="text" class="form-control" name="desc" rows="5" placeholder="Enter description" required><?php echo htmlspecialchars($video['description']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="rental_fee">Rental Fee</label>
                            <input type="number" step="0.01" class="form-control" name="rental_fee" value="<?php echo htmlspecialchars($video['rental_fee']); ?>" min="0" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="length">Length</label>
                            <div class="row">
                                <div class="col">
                                    <input type="number" class="form-control" name="hours" value="<?php echo htmlspecialchars($hours); ?>" placeholder="Hours" min="0" required>
                                </div>
                                <div class="col">
                                    <input type="number" class="form-control" name="minutes" value="<?php echo htmlspecialchars($minutes); ?>" placeholder="Minutes" min="0" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="Image">Cover Image</label>
                            <?php if (!empty($video['Image'])): ?>
                                <img src="<?php echo htmlspecialchars($video['Image']); ?>" alt="Cover Image" class="img-fluid mb-3">
                            <?php endif; ?>
                            <input type="file" class="form-control" name="Image" accept="image/*">
                            <small class="form-text text-muted">Upload a new cover image for the video. Leave blank to keep the current image.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" name="submit" class="btn admin_button mx-2">Update Video</button>
                <button type="button" class="btn admin_button mx-2" onclick="window.location.href='index.php?page=view';">Cancel</button>
            </div>
        </form>
    </div>
</div>

<?php
    } else {
        echo '<div class="alert alert-warning">Video not found.</div>';
    }
} else {
    echo '<div class="alert alert-danger">No video ID specified.</div>';
}
?>