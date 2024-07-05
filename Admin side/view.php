<?php
require_once 'functions.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$videos = getVideos();

?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">All Videos</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Release Year</th>
                    <th>Available Copies</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($videos) > 0) {
                    foreach ($videos as $video) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($video['video_title']) . "</td>";
                        echo "<td>" . htmlspecialchars($video['genre']) . "</td>";
                        echo "<td>" . htmlspecialchars($video['release_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($video['num_videos_available']) . "</td>";
                        echo "<td>
                                <a href='index.php?page=edit&id={$video['video_id']}' class='btn btn-info'>Edit</a>
                                <a href='index.php?page=delete&id={$video['video_id']}' class='btn btn-danger'>Delete</a>
                                <a href='index.php?page=view_single&id={$video['video_id']}' class='btn btn-primary'>View Details</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No videos found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
