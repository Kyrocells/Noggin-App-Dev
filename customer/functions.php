<?php

function dbConnect() {
    $host = 'localhost'; 
    $dbname = 'video_rental_noggin'; 
    $username = 'root'; 
    $password = '';

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function updateUserProfile($user_id, $username, $password, $first_name, $last_name, $email, $contact_number, $profile_picture) {
    $conn = dbConnect();
    
    $user_id = $conn->real_escape_string($user_id);
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);
    $first_name = $conn->real_escape_string($first_name);
    $last_name = $conn->real_escape_string($last_name);
    $email = $conn->real_escape_string($email);
    $contact_number = $conn->real_escape_string($contact_number);
    $profile_picture = $conn->real_escape_string($profile_picture);

    $sql = "UPDATE users SET 
            username = '$username', 
            password = '$password', 
            first_name = '$first_name', 
            last_name = '$last_name', 
            email = '$email', 
            contact_number = '$contact_number', 
            profile_picture = '$profile_picture' 
            WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $conn->close();
        return false;
    }
}


function getUserProfile($user_id) {
    $conn = dbConnect();
    $sql = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    return $user;
}

function getVideoDetails($video_id) {
    $conn = dbConnect();

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT * FROM videos WHERE video_id = ?");
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the video details
    if ($result->num_rows > 0) {
        $video = $result->fetch_assoc();
    } else {
        $video = null;
    }

    $stmt->close();
    $conn->close();

    return $video;
}

function getTransactionDetails($video_id) {
    $conn = dbConnect();
    
    $sql = "
        SELECT rv.start_date, rv.return_date, th.total_price, th.method_of_payment
        FROM rented_videos rv
        JOIN transaction_history th ON rv.video_id = th.video_id
        WHERE rv.video_id = ? AND rv.returned = 1
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $video_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaction = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
    
    return $transaction;
}
?>
