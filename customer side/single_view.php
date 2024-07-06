<div class="card col-md-6 align_view_single">
    <div class="card-header video_details">
    <p class="card-title video_title">Video Details</p>
        <a href="index.php?page=rent"><button type="button" class="btn back_button"><</button></a>
    </div>
    <div class="card-body">
        <?php echo htmlspecialchars($video['image']); ?>
        <p><strong>Title:</strong> <?php echo htmlspecialchars($video['title']); ?></p>
        <p><strong>Genre:</strong> <?php echo htmlspecialchars($video['genre']); ?></p>
        <p><strong>Release Year:</strong> <?php echo htmlspecialchars($video['release_year']); ?></p>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($video['description']); ?></p>
        <p><strong>Actors:</strong> <?php echo htmlspecialchars($video['actors']); ?></p>
        <p><strong>Duration:</strong> <?php 
                                        echo htmlspecialchars($video['hours'])." hours ".htmlspecialchars($video['minutes'])." minutes"; 
                                        ?></p>
        <p><strong>Price:</strong> <?php echo htmlspecialchars($video['price']); ?></p>
    </div>
    <div class="card-footer">
        <button class="rent_button">Rent</button>
    </div>
</div>