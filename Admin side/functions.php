<?php
require_once 'addVideo_db.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
