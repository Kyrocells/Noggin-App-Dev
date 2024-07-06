<?php
require_once 'functions.php';

if (isset($_GET['video_id'])) {
    $video_id = $_GET['video_id'];
    $video = getVideoDetails($video_id);
} else {
    echo "No video ID provided.";
    exit();
}
?>

<div class="card col-md-6 align_view_single">
    <div class="card-header video_details">
        <p class="card-title video_title">Video Details</p>
        <a href="index.php?page=rent"><button type="button" class="btn back_button">&lt;</button></a>
    </div>
    <div class="card-body">
        <?php if (!empty($video['image'])): ?>
            <img src="<?php echo htmlspecialchars($video['image']); ?>" alt="Video Image" class="img-fluid">
        <?php endif; ?>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($video['video_title']); ?></p>
        <p><strong>Genre:</strong> <?php echo htmlspecialchars($video['genre']); ?></p>
        <p><strong>Release Year:</strong> <?php echo htmlspecialchars($video['release_date']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($video['description']); ?></p>
        <p><strong>Actors:</strong> <?php echo htmlspecialchars($video['actors']); ?></p>
        <p><strong>Duration:</strong> <?php 
            echo htmlspecialchars($video['length'])." hours"; 
        ?></p>
        <p><strong>Price:</strong> <?php echo htmlspecialchars($video['rental_fee']); ?></p>
    </div>
    <div class="card-footer">
        <form action="index.php" method="get">
            <input type="hidden" name="page" value="rent_payment">
            <input type="hidden" name="video_id" value="<?php echo $video_id; ?>">
            <button type="submit" class="rent_button">Rent</button>
        </form>
    </div>
</div>
