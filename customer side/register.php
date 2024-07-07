<?php
require_once 'functions.php';

$invalid_credentials = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password before storing
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the data into the database
    $conn = dbConnect();
    $username = $conn->real_escape_string($username);
    $first_name = $conn->real_escape_string($first_name);
    $last_name = $conn->real_escape_string($last_name);
    $phone = $conn->real_escape_string($phone);
    $address = $conn->real_escape_string($address);
    $city = $conn->real_escape_string($city);
    $email = $conn->real_escape_string($email);
    $hashed_password = $conn->real_escape_string($hashed_password);

    $sql = "INSERT INTO users (username, first_name, last_name, contact_number, address, city, email, password) VALUES ('$username', '$first_name', '$last_name', '$phone', '$address', '$city', '$email', '$hashed_password')";

    try {
        if ($conn->query($sql) === TRUE) {
            // Redirect to login page after successful registration
            header('Location: login.php');
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) { // 1062 is the error code for duplicate entry
            $invalid_credentials = "You can't use this username/email";
        } else {
            $invalid_credentials = "Error: " . $e->getMessage();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #88c3d8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        span {
            color: white !important;
            background-color: #1E5162 !important;
        }
        .container {
            background-color: #5b97ad;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .header {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        .header .logo {
            padding-left: 45px;
        }
        .header .logo img {
            max-width: 150px;
            height: auto;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 36px;
            padding-left: 80px;
        }
        .form-group {
            width: 100%;
            margin-bottom: 20px;
            padding: 5px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #ffffff;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #ffffff;
            font-size: 16px;
        }
        .form-group.inline {
            display: flex;
            justify-content: space-between;
        }
        .form-group.inline .first-name-input {
            width: 48%;
        }
        .form-group.inline .last-name-input {
            width: 48%;
        }
        .form-group .submit-btn {
            width: 200px;
            padding: 15px;
            display: block;
            margin: 0 auto;
            background-color: #1E5162;
            border: none;
            color: #ffffff;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .form-group .submit-btn:hover {
            color: #fff;
            background-color: #13333d;
            font-weight: 500;
        }
        .register-link a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
        .row {
            align-items: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="logo">
            <a href="homepage.html"><img src="../img/logo.png" alt="Logo"></a>
        </div>
        <h1>Register</h1>
    </div>
    <form action="register.php" method="post" id="registration">
        <div class="row mt-4">
            <div class="col-md-5">
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <!-- Username -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
            </div>
            <div class="col-md-7">
                <!-- First Name and Last Name -->
                <div class="form-group">
                    <label for="first_name">Name</label>
                    <div class="input-group">
                        <span class="input-group-text">First Name</span>
                        <input type="text" id="first_name" name="first_name" class="form-control" required>
                        <span class="input-group-text">Last Name</span>
                        <input type="text" id="last_name" name="last_name" class="form-control" required>
                    </div>
                </div>
                <!-- Phone Number -->
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" pattern="[0-9]{11}" required>
                </div>
                <!-- Address -->
                <div class="form-group">
                    <label for="first_name">Address</label>
                    <div class="input-group">
                        <span class="input-group-text" for="address">Address</span>
                        <input type="text" id="address" name="address" class="form-control" required>
                        <span class="input-group-text" for="city">City</span>
                        <input type="text" id="city" name="city" class="form-control" required>
                    </div>
                </div>
            </div>
        </div>
        <!-- Submit Button -->
        <div class="form-group">
            <input type="submit" class="submit-btn" value="Register">
        </div>
        <!-- Invalid credentials -->
        <?php if ($invalid_credentials): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?php echo $invalid_credentials; ?>
            </div>
        <?php endif; ?>
    </form>
    <!-- Login Link -->
    <div class="register-link text-center mt-4">
        <p>Already have an account? <a href="login.php">Login here.</a></p>
    </div>
</div>

<script>
    function validateForm() {
        var email = document.getElementById('email').value;
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        var firstName = document.getElementById('first_name').value;
        var lastName = document.getElementById('last_name').value;
        var phone = document.getElementById('phone').value;
        var address = document.getElementById('address').value;
        var city = document.getElementById('city').value;

        if (!email.includes('@') || !email.includes('.')) {
            alert('Please enter a valid email address.');
            return false;
        }

        if (username.length < 4) {
            alert('Username must be at least 4 characters long.');
            return false;
        }

        if (password.length < 6) {
            alert('Password must be at least 6 characters long.');
            return false;
        }

        if (!(/^\d{11}$/.test(phone))) {
            alert('Please enter a valid phone number (digits only).');
            return false;
        }

        if (firstName === '' || lastName === '' || address === '' || city === '') {
            alert('Please fill out all required fields.');
            return false;
        }

        return true;
    }

    document.getElementById('registration').onsubmit = function() {
        return validateForm();
    };
</script>
</body>
</html>
