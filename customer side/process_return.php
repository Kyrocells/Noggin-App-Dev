<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_start();

    $video_id = $_GET['video_id'];
    $video_format = $_GET['video_format'];
    $user_id = $_SESSION['user_id'];

    $conn = dbConnect();

    // Update the rented_videos table to mark the video as returned
    $stmt = $conn->prepare("UPDATE rented_videos SET returned = 1, return_date = ? WHERE video_id = ? AND user_id = ? AND video_format = ?");
    $return_date = date('Y-m-d');
    $stmt->bind_param("siss", $return_date, $video_id, $user_id, $video_format);
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

    $conn->close();

    // Redirect back to the rent history page
    header('Location: index.php?page=rent_history');
    exit();
}
