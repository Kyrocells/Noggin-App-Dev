<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (isset($_GET['id'])) {
        $video_id = $_GET['id'];
        $video_title = isset($_POST['video_title']) ? $_POST['video_title'] : '';
        $genre = isset($_POST['genre']) ? $_POST['genre'] : '';
        $release_date = isset($_POST['release_date']) ? $_POST['release_date'] : '';
        $num_videos_available = isset($_POST['num_videos_available']) ? $_POST['num_videos_available'] : '';
        $video_format = isset($_POST['video_format']) ? $_POST['video_format'] : '';
        $rental_fee = isset($_POST['rental_fee']) ? $_POST['rental_fee'] : '';
        $hours = isset($_POST['hours']) ? $_POST['hours'] : '';
        $minutes = isset($_POST['minutes']) ? $_POST['minutes'] : '';

        editVideo($video_id, $video_title, $genre, $release_date,
            $num_videos_available, $video_format, $rental_fee, $hours, $minutes);
        
        echo '<div class="alert alert-success">Video updated successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">No video ID specified.</div>';
    }
}

if (isset($_GET['id'])) {
    $video = getVideoById($_GET['id']);
    if ($video !== null) {
?>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Edit Video</h3>
    </div>
    <form action="index.php?page=edit&id=<?php echo $video['video_id']; ?>" method="post">
        <div class="card-body">
            <div class="form-group">
                <label>Title</label>
                <input type="text" class="form-control" name="video_title" value="<?php echo htmlspecialchars($video['video_title']); ?>" required>
            </div>
            <div class="form-group">
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
            <div class="form-group">
                <label>Release Year</label>
                <input type="number" class="form-control" name="release_date" value="<?php echo htmlspecialchars($video['release_date']); ?>" required>
            </div>
            <div class="form-group">
                <label>Copies</label>
                <input type="number" class="form-control" name="num_videos_available" value="<?php echo htmlspecialchars($video['num_videos_available']); ?>" required>
            </div>
            <div class="form-group">
                <label for="video_format">Video Format</label><br>
                <input type="radio" id="dvd" name="video_format" value="DVD" <?php if ($video['video_format'] === 'DVD') echo 'checked'; ?> required>
                <label for="dvd">DVD</label><br>
                <input type="radio" id="bluray" name="video_format" value="Blu-ray" <?php if ($video['video_format'] === 'Blu-ray') echo 'checked'; ?> required>
                <label for="bluray">Blu-ray</label><br>
                <input type="radio" id="digital" name="video_format" value="Digital" <?php if ($video['video_format'] === 'Digital') echo 'checked'; ?> required>
                <label for="digital">Digital</label><br>
            </div>
            <div class="form-group">
                <label for="rental_fee">Rental Fee</label>
                <input type="number" step="0.01" class="form-control" name="rental_fee" value="<?php echo htmlspecialchars($video['rental_fee']); ?>" required>
            </div>
            <div class="form-group">
                <label for="length">Length</label>
                <div class="row">
                    <div class="col">
                        <input type="number" class="form-control" name="hours" value="<?php echo floor($video['length'] / 3600); ?>" placeholder="Hours" min="0" required>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" name="minutes" value="<?php echo floor(($video['length'] % 3600) / 60); ?>" placeholder="Minutes" min="0" max="59" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" name="submit" class="btn btn-info">Update Video</button>
            <button type="button" class="btn btn-default" onclick="window.location.href='index.php?page=view';">Cancel</button>
        </div>
    </form>
</div>
<?php
    } else {
        echo '<div class="alert alert-warning">Video not found.</div>';
    }
} else {
    echo '<div class="alert alert-danger">No video ID specified.</div>';
}
?>
