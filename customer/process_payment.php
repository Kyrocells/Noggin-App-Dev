<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

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
    $video_format = $_POST['video_format'];
    $payment_method = $_POST['payment_method'];

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

    // Fetch video title from the videos table
    $stmt = $conn->prepare("SELECT video_title FROM videos WHERE video_id = ?");
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $stmt->bind_result($video_title);
    $stmt->fetch();
    $stmt->close();
    $conn->begin_transaction();

    try {
        // Insert into rented_videos with returned set to 0
        $stmt = $conn->prepare("INSERT INTO rented_videos (video_id, user_id, renter_name, return_date, start_date, returned, video_format) VALUES (?, ?, ?, ?, ?, 0, ?)");
        $stmt->bind_param("iissss", $video_id, $user_id, $renter_name, $return_date, $start_date, $video_format);
        $stmt->execute();
        $rental_id = $stmt->insert_id; // Get the inserted rental_id
        $stmt->close();

        // Update the stock of the selected video format
        if ($video_format === 'DVD') {
            $stmt = $conn->prepare("UPDATE videos SET dvd_stocks = dvd_stocks - 1 WHERE video_id = ?");
        } elseif ($video_format === 'Blu-ray') {
            $stmt = $conn->prepare("UPDATE videos SET bray_stocks = bray_stocks - 1 WHERE video_id = ?");
        }
        if ($video_format !== 'Digital') {
            $stmt->bind_param("i", $video_id);
            $stmt->execute();
            $stmt->close();
        }

        // Decrease the number of copies in the videos table
        $stmt = $conn->prepare("UPDATE videos SET num_videos_available = num_videos_available - 1 WHERE video_id = ?");
        $stmt->bind_param("i", $video_id);
        $stmt->execute();
        $stmt->close();

        // Insert into transaction_history
        $transaction_date = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO transaction_history (date, total_price, user_id, video_id, method_of_payment, video_format, rental_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdisssi", $transaction_date, $price, $user_id, $video_id, $payment_method, $video_format, $rental_id);
        $stmt->execute();
        $stmt->close();

        $conn->commit();

        // Send confirmation email
        $subject = 'Payment Confirmation';
        $message = "Dear $renter_name,\n\nThank you for your payment. Here are the details:\n\nVideo Title: $video_title\nTotal Price: $price\nPayment Method: $payment_method\n\nStart Date: $start_date\nReturn Date: $return_date\n\nThank you for choosing our service!\n\nBest regards,\nVideo Rental Service";

        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'whale3871@gmail.com'; // Your Gmail address
            $mail->Password = 'almizdofpkezpkgs'; // Your Gmail app password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('your_email@gmail.com', 'Video Rental Service');
            $mail->addAddress($email, $renter_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = nl2br($message);
            $mail->AltBody = $message;

            $mail->send();
            echo 'Email has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

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