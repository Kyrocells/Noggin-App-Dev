<?php

require 'addVideo_db.php';

header('Content-Type: application/json');


$sql = "SELECT video_title, num_videos_available FROM videos";
$result = $conn->query($sql);

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();


echo json_encode($data);

?>
