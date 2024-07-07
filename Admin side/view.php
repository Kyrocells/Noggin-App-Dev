<?php
require_once 'functions.php';

$videos = getVideos();

?>
<div class="container view_container">
    <div class="card view_card">
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
                        <th>Digital</th>
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
                            echo "<td>" . ($video['digital'] ? 'Available' : 'Not Available') . "</td>";
                            echo "<td class='actions'>
                                    <a href='index.php?page=edit&id={$video['video_id']}' class='btn admin_button mx-2'>Edit</a>
                                    <a href='index.php?page=delete&id={$video['video_id']}' class='btn admin_button mx-2'>Delete</a>
                                </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No videos found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
