<?php
require_once 'functions.php';

if (isset($_GET['video_id'])) {
    $video_id = $_GET['video_id'];
    $user_id = $_GET['user_id'];
    //add additional nalang dito to determine etc. idk
    $video = getVideoDetails($video_id);
} else {
    echo "No video ID provided.";
    exit();
}
?>

<div class="card col-md-6 align_view_single">
    <div class="card-header video_details">
        <p class="card-title video_title">Video Details</p>
    </div>
    <div class="card-body">
        <?php if (!empty($video['image'])): ?>
            <img src="<?php echo htmlspecialchars($video['image']); ?>" alt="Video Image" class="img-fluid">
        <?php endif; ?>
        <p><strong>Transaction ID:</strong> <?php echo htmlspecialchars($video['transaction_id']); ?></p>
        <p><strong>Date:</strong> <?php echo htmlspecialchars($video['date']); ?></p>
        <p><strong>Price:</strong> <?php echo htmlspecialchars($video['total_price']); ?></p>
        <p><strong>Payment Type:</strong> <?php echo htmlspecialchars($video['method_of_payment']); ?></p>
    </div>
    <div class="card-footer">
        <a href="index.php?page=rent_history"><button type="button" class="btn back_button">Back</button></a>
    </div>
</div>