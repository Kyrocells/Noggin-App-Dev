<?php
$servername = "localhost"; // change this to your database server
$username = "your_username"; // change this to your database username
$password = "your_password"; // change this to your database password
$dbname = "your_database"; // change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
