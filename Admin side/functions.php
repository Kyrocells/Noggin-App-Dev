<?php
require_once 'addVideo_db.php'; // Include your database connection file

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function addVideo($title, $genre, $release_year, $numCopies, $videoformat, $price, $hours, $minutes) {
    global $conn;

    $total_length = $hours * 3600 + $minutes * 60;

    
    $stmt = $conn->prepare("INSERT INTO videos (video_title, genre, release_date, num_videos_available, video_format, rental_fee, length)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiissi", $title, $genre, $release_year, $numCopies, $videoformat, $price, $total_length);

    
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

function editVideo($id, $title, $genre, $release_year, $numCopies, $videoformat, $price, $hours, $minutes) {
    global $conn;

    
    $total_length = $hours * 3600 + $minutes * 60;

    
    $stmt = $conn->prepare("UPDATE videos SET video_title = ?, genre = ?, release_date = ?, num_videos_available = ?, 
                            video_format = ?, rental_fee = ?, length = ? WHERE video_id = ?");
    $stmt->bind_param("ssiissii", $title, $genre, $release_year, $numCopies, $videoformat, $price, $total_length, $id);

    
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
?>
