<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

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

    // Fetch video title from the videos table
    $stmt = $conn->prepare("SELECT video_title FROM videos WHERE video_id = ?");
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $stmt->bind_result($video_title);
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

    // Fetch user details
    $stmt = $conn->prepare("SELECT email, first_name, last_name FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($user_email, $first_name, $last_name);
    $stmt->fetch();
    $stmt->close();

    $conn->close();

    // Send return confirmation email
    $renter_name = $first_name . ' ' . $last_name;
    $subject = 'Return Confirmation';
    $message = "Dear $renter_name,\n\nYour return has been processed successfully. Here are the details:\n\nVideo Title: $video_title\nReturn Date: $current_date\nOverdue Fee: $overdue_fee\n\nThank you for choosing our service!\n\nBest regards,\nVideo Rental Service";

    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'whale3871@gmail.com';
        $mail->Password = 'almizdofpkezpkgs'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your_email@gmail.com', 'Video Rental Service');
        $mail->addAddress($user_email, $renter_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = nl2br($message);
        $mail->AltBody = $message;

        $mail->send();
        echo 'Return confirmation email has been sent';
    } catch (Exception $e) {
        echo "Return confirmation email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

    // Redirect back to the rent history page
    header('Location: index.php?page=rent_history');
    exit();
}
?>
