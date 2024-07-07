<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once 'functions.php';

    // Check if file was uploaded successfully
    if (isset($_FILES['Image']) && $_FILES['Image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['Image'];
    } else {
        // Handle case where no file was uploaded or there was an error
        echo "No file uploaded or invalid file.";
        // You might want to handle this error more gracefully, depending on your application logic
        exit; // Stop execution if file upload failed
    }

    // Call addVideo function with all parameters
    addVideo($_POST['title'], $_POST['genre'], $_POST['release_year'], $_POST['dvdCopies'], $_POST['blurayCopies'], $_POST['digitalFormat'], $_POST['price'], $_POST['hours'], $_POST['minutes'], $_POST['actors'], $_POST['desc'], $image);
}
?>

<div class="card add_container">
    <div class="card-header">
        <h3 class="card-title">Add New Video</h3>
    </div>
    <form action="index.php?page=add" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="row">
                <!-- First Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter title" required>
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>
                        <select class="form-control" name="genre" required>
                            <option value="">Select genre</option>
                            <option value="Action">Action</option>
                            <option value="Comedy">Comedy</option>
                            <option value="Drama">Drama</option>
                            <option value="Fantasy">Fantasy</option>
                            <option value="Horror">Horror</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="release_year">Release Year</label>
                        <input type="number" class="form-control" name="release_year" placeholder="Enter release year" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="actors">Actors</label>
                        <input type="text" class="form-control" name="actors" placeholder="Enter actors" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea class="form-control" name="desc" rows="5" placeholder="Enter description" required></textarea>
                    </div>
                </div>

                <!-- Second Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dvdCopies">DVD Copies</label>
                        <input type="number" class="form-control" name="dvdCopies" placeholder="Enter DVD Copies" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="blurayCopies">Blu-ray Copies</label>
                        <input type="number" class="form-control" name="blurayCopies" placeholder="Enter Blu-ray Copies" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="digitalFormat">Digital Format</label><br>
                        <input type="radio" id="digitalYes" name="digitalFormat" value="Yes" required>
                        <label for="digitalYes">Yes</label><br>
                        <input type="radio" id="digitalNo" name="digitalFormat" value="No" required>
                        <label for="digitalNo">No</label><br>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" placeholder="Enter price" required min="0">
                    </div>
                    <div class="form-group">
                        <label for="length">Length</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="hours" placeholder="Hours" required min="0">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="minutes" placeholder="Minutes" required min="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="Image">Cover Image</label>
                        <input type="file" class="form-control" name="Image" accept="image/*" required>
                        <small class="form-text text-muted">Upload a cover image for the video.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn admin_button">Add Video</button>
        </div>
    </form>
</div>
