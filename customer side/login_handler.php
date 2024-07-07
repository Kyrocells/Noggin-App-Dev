<?php
require_once 'functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = dbConnect();

    $email = $conn->real_escape_string($email);
    $password = $conn->real_escape_string($password);
    
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start();
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['email'] = $user['email'];

        if ($user['admin_rights'] == 1) {
            header('Location: ../admin/index.php');
        } else {
            header('Location: index.php');
        }
        exit();
    } else {
        // Invalid login
        echo "Invalid email or password.";
    }

    $conn->close();
}
?>
