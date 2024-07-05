<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require_once 'functions.php';

    
    $total_length = $_POST['hours'] * 3600 + $_POST['minutes'] * 60;

    addVideo($_POST['title'], $_POST['genre'], $_POST['release_year'], $_POST['numCopies'], $_POST['video_format'], $_POST['price'], $_POST['hours'], $_POST['minutes']);
}
?>


<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add New Video</h3>
    </div>
    <form action="index.php?page=add" method="post" enctype="multipart/form-data">
        <div class="card-body">
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
                        <input type="number" class="form-control" name="hours" placeholder="Hours" min="0" required>
                    </div>
                    <div class="col">
                        <input type="number" class="form-control" name="minutes" placeholder="Minutes" min="0" max="59" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add Video</button>
        </div>
    </form>
    <script>
    async function fetchData(url) {
        const response = await fetch(url);
        return response.json();
    }

    async function init() {
        const videoData = await fetchData('http://localhost/TW21/Project/videos_data.php'); // Update with the correct path
        const doughnutConfig = {
            type: 'doughnut',
            data: {
                labels: videoData.map(item => item.Title),
                datasets: [{
                    data: videoData.map(item => item.Copies),
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(75, 192, 192)',
                        'rgb(255, 205, 86)',
                        'rgb(201, 203, 207)',
                        'rgb(54, 162, 235)'
                    ]
                }]
            }
        };

        const ctx1 = document.getElementById('myChart').getContext('2d');
        new Chart(ctx1, doughnutConfig);
    }

    window.onload = init;
</script>
</div>