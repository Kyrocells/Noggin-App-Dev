<?php
require_once 'functions.php';

if (isset($_GET['video_id'])) {
    $video_id = $_GET['video_id'];
    $video = getVideoDetails($video_id);
    $transaction = getTransactionDetails($video_id);
} else {
    echo "No video ID provided.";
    exit();
}
?>

<div class="single_return_container">
<div class="card col-md-6 single_return">
    <div class="card-header video_details">
        <p class="card-title video_title single_return_title">Video Return Details</p>
        <a href="index.php?page=rent_history"><button type="button" class="back_button">Back</button></a>
    </div>
    <div class="card-body">
        <p><strong>Title:</strong> <?php echo htmlspecialchars($video['video_title']); ?></p>
        <p><strong>Start of Rent:</strong> <?php echo htmlspecialchars($transaction['start_date']); ?></p>
        <p><strong>End of Rent:</strong> <?php echo htmlspecialchars($transaction['return_date']); ?></p>
        <p><strong>Total Price:</strong> <?php echo htmlspecialchars($transaction['total_price']); ?></p>
        <p><strong>Method of Payment:</strong> <?php echo htmlspecialchars($transaction['method_of_payment']); ?></p>
    </div>
</div>
</div>
