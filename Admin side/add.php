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
    addVideo($_POST['title'], $_POST['genre'], $_POST['release_year'], $_POST['numCopies'], $_POST['video_format'], $_POST['price'], $_POST['hours'], $_POST['minutes'], $_POST['actors'],$_POST['desc'],$image);
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
                        <input type="number" class="form-control" name="release_year" placeholder="Enter release year" required>
                    </div>
                    <div class="form-group">
                        <label for="numCopies">Copies</label>
                        <input type="number" class="form-control" name="numCopies" placeholder="Enter Copies available" required>
                    </div>
                    <div class="form-group">
                        <label for="actors">Actors</label>
                        <input type="text" class="form-control" name="actors" placeholder="Enter actors" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea type="text" class="form-control" name="desc"  rows="5" placeholder="Enter description" required></textarea>
                    </div>
                </div>

                <!-- Second Column -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="video_format">Video Format</label><br>
                        <input type="radio" id="dvd" name="video_format" value="DVD" required>
                        <label for="dvd">DVD</label><br>
                        <input type="radio" id="bluray" name="video_format" value="Blu-ray" required>
                        <label for="bluray">Blu-ray</label><br>
                        <input type="radio" id="digital" name="video_format" value="Digital" required>
                        <label for="digital">Digital</label><br>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control" name="price" placeholder="Enter price" required>
                    </div>
                    <div class="form-group">
                        <label for="length">Length</label>
                        <div class="row">
                            <div class="col">
                                <input type="text" class="form-control" name="hours" placeholder="Hours" required>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="minutes" placeholder="Minutes" required>
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


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    async function fetchData(url) {
        const response = await fetch(url);
        return response.json();
    }

    async function init() {
        try {
            const videoData = await fetchData('http://localhost/TW21/FinalProject/videos_data.php'); // Update with the correct path

            const doughnutConfig = {
                type: 'line',
                data: {
                    labels: videoData.map(item => item.video_title),
                    datasets: [{
                        label: 'Number of Videos Available',
                        data: videoData.map(item => item.num_videos_available),
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };

            const ctx = document.getElementById('myChart').getContext('2d');
            new Chart(ctx, doughnutConfig);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    window.onload = init;
</script>