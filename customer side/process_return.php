<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_start();

    $rental_id = $_GET['rental_id'];
    $user_id = $_SESSION['user_id'];

    $conn = dbConnect();

    // Fetch rental details
    $stmt = $conn->prepare("SELECT video_id, video_format, return_date FROM rented_videos WHERE rental_id = ?");
    $stmt->bind_param("i", $rental_id);
    $stmt->execute();
    $stmt->bind_result($video_id, $video_format, $expected_return_date);
    $stmt->fetch();
    $stmt->close();

    // Calculate the overdue fee if applicable
    $current_date = date('Y-m-d');
    $overdue_fee = 0;
    if ($current_date > $expected_return_date) {
        $overdue_fee = 300;
    }

    // Update the rented_videos table to mark the video as returned
    $stmt = $conn->prepare("UPDATE rented_videos SET returned = 1, return_date = ? WHERE rental_id = ?");
    $stmt->bind_param("si", $current_date, $rental_id);
    $stmt->execute();
    $stmt->close();

    // Increase the number of copies in the videos table if not digital
    if ($video_format !== 'Digital') {
        if ($video_format === 'DVD') {
            $stmt = $conn->prepare("UPDATE videos SET dvd_stocks = dvd_stocks + 1 WHERE video_id = ?");
        } elseif ($video_format === 'Blu-ray') {
            $stmt = $conn->prepare("UPDATE videos SET bray_stocks = bray_stocks + 1 WHERE video_id = ?");
        }
        $stmt->bind_param("i", $video_id);
        $stmt->execute();
        $stmt->close();
    }

    // Update the total number of available copies
    $stmt = $conn->prepare("UPDATE videos SET num_videos_available = num_videos_available + 1 WHERE video_id = ?");
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $stmt->close();

    // Update the transaction_history with the overdue fee if applicable
    $stmt = $conn->prepare("UPDATE transaction_history SET total_price = total_price + ? WHERE rental_id = ?");
    $stmt->bind_param("ii", $overdue_fee, $rental_id);
    $stmt->execute();
    $stmt->close();

    $conn->close();

    // Redirect back to the rent history page
    header('Location: index.php?page=rent_history');
    exit();
}
