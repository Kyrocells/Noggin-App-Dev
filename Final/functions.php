<?php

require_once 'addVideo_db.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function dbConnect() {
    $host = 'localhost'; // Your database host
    $dbname = 'video_rental_noggin'; // Your database name
    $username = 'root'; // Your database username
    $password = ''; // Your database password

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

function addVideo($title, $genre, $release_year, $dvdCopies, $blurayCopies, $digitalFormat, $price, $hours, $minutes, $actors, $desc, $image) {
    global $conn;

    // Handle image upload
    if (!isset($image) || !isset($image['tmp_name']) || empty($image['tmp_name'])) {
        echo "No file uploaded or invalid file.";
        return;
    }

    $targetDir = "../img/";

    if (!file_exists($targetDir) && !is_dir($targetDir)) {
        mkdir($targetDir, 0755, true); 
    }

    $targetFile = $targetDir . basename($image['name']);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($image['tmp_name']);
    if ($check === false) {
        echo "File is not an image.";
        return;
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return;
    }

    // Upload file
    if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
        echo "Sorry, there was an error uploading your file.";
        return;
    }

    $length = $hours . ':' . $minutes;

    // Convert digitalFormat to 1 or 0
    $digital = ($digitalFormat === 'Yes') ? 1 : 0;

    // Calculate total copies
    $numCopies = $dvdCopies + $blurayCopies;

    // Insert into videos table
    $stmt = $conn->prepare("INSERT INTO videos (video_title, genre, release_date, num_videos_available, dvd_stocks, bray_stocks, digital, rental_fee, length, image, actors, description)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiisiiissss", $title, $genre, $release_year, $numCopies, $dvdCopies, $blurayCopies, $digital, $price, $length, $targetFile, $actors, $desc);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                Video added successfully.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


function getVideos() {
    global $conn;

    $videos = [];
    $sql = "SELECT * FROM videos";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $videos[] = $row;
        }
    }

    return $videos;
}

function getVideoById($id) {
    global $conn;

    $sql = "SELECT * FROM videos WHERE video_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}

function editVideo($id, $title, $genre, $release_year, $dvdCopies, $blurayCopies, $digitalFormat, $price, $hours, $minutes, $actors, $desc, $image) {
    global $conn;

    $total_length = $hours . ':' . $minutes;

    // Convert digitalFormat to 1 or 0
    $digital = ($digitalFormat === 'Yes') ? 1 : 0;

    // Calculate total copies
    $numCopies = $dvdCopies + $blurayCopies;

    // Handle image upload
    if (!empty($image['name'])) {
        // Directory where images will be stored
        $targetDir = "../img/";

        // Create the directory if it doesn't exist
        if (!file_exists($targetDir) && !is_dir($targetDir)) {
            mkdir($targetDir, 0755, true); // Create uploads directory with full permissions
        }

        $targetFile = $targetDir . basename($image['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($image['tmp_name']);
        if ($check === false) {
            echo "File is not an image.";
            return false;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return false;
        }

        // Upload file
        if (!move_uploaded_file($image['tmp_name'], $targetFile)) {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }

        // Update database with new image path
        $stmt = $conn->prepare("UPDATE videos SET video_title = ?, genre = ?, release_date = ?, dvd_stocks = ?, bray_stocks = ?, digital = ?, num_videos_available = ?, rental_fee = ?, length = ?, actors = ?, description = ?, Image = ? WHERE video_id = ?");
        $stmt->bind_param("ssiisisissssi", $title, $genre, $release_year, $dvdCopies, $blurayCopies, $digital, $numCopies, $price, $total_length, $actors, $desc, $targetFile, $id);
    } else {
        // Update database without changing image
        $stmt = $conn->prepare("UPDATE videos SET video_title = ?, genre = ?, release_date = ?, dvd_stocks = ?, bray_stocks = ?, digital = ?, num_videos_available = ?, rental_fee = ?, length = ?, actors = ?, description = ? WHERE video_id = ?");
        $stmt->bind_param("ssiisisisssi", $title, $genre, $release_year, $dvdCopies, $blurayCopies, $digital, $numCopies, $price, $total_length, $actors, $desc, $id);
    }

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error updating record: " . $stmt->error;
        return false;
    }
}




function deleteVideo($id) {
    global $conn;

    $stmt = $conn->prepare("DELETE FROM videos WHERE video_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        return true;
    } else {
        echo "Error deleting record: " . $stmt->error;
        return false;
    }
}

function getTransactionHistory() {
    global $conn;
    
    $sql = "SELECT * FROM transaction_history";
    $result = $conn->query($sql);

    $transactions = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
    }

    return $transactions;
}

?>

