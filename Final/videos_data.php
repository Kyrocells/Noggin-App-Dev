<?php
require 'addVideo_db.php';

header('Content-Type: application/json');

$sql = "SELECT DATE_FORMAT(r.start_date, '%Y-%m') AS month_year, SUM(v.num_videos_available) AS total_sold
        FROM rented_videos r
        JOIN videos v ON r.video_id = v.video_id
        GROUP BY DATE_FORMAT(r.start_date, '%Y-%m')
        ORDER BY DATE_FORMAT(r.start_date, '%Y-%m')";

$data = array();

if ($result = $conn->query($sql)) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $result->free();
} else {
    $data['error'] = 'Query failed';
}

$conn->close();

echo json_encode($data);
?>

