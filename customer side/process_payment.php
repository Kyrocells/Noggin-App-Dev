<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start();

    // Fetch user_id from session
    $user_id = $_SESSION['user_id'];

    // Get form data
    $video_id = $_POST['video_id'];
    $price = $_POST['total_price'];  // Use the total price calculated
    $email = $_POST['email'];
    $start_date = $_POST['start_date'];
    $return_date = $_POST['return_date'];
    $payment_method = isset($_POST['cardNumber']) ? 'Card' : 'Gcash';

    // If payment is by card, also get card details
    if ($payment_method === 'Card') {
        $card_number = $_POST['cardNumber'];
        $expiry_date = $_POST['expiryDate'];
        $cvv = $_POST['cvv'];
    }

    // Connect to the database
    $conn = dbConnect();

    // Fetch user details from database
    $stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    $renter_name = $user['first_name'] . ' ' . $user['last_name'];

    $conn->begin_transaction();

    try {
        // Insert into rented_videos
        $stmt = $conn->prepare("INSERT INTO rented_videos (video_id, user_id, renter_name, return_date, start_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iisss", $video_id, $user_id, $renter_name, $return_date, $start_date);
        $stmt->execute();
        $stmt->close();

        // Decrease the number of copies in the videos table
        $stmt = $conn->prepare("UPDATE videos SET num_videos_available = num_videos_available - 1 WHERE video_id = ?");
        $stmt->bind_param("i", $video_id);
        $stmt->execute();
        $stmt->close();

        // Insert into transaction_history
        $transaction_date = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO transaction_history (date, total_price, user_id, video_id, method_of_payment) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sdiis", $transaction_date, $price, $user_id, $video_id, $payment_method);
        $stmt->execute();
        $stmt->close();

        $conn->commit();

        // Redirect to a success page
        header('Location: index.php?page=rent_payment_success');
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        echo "Failed to process payment: " . $e->getMessage();
    }

    $conn->close();
}
?>
