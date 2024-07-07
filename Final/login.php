<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'customer/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = dbConnect();

    $email = $conn->real_escape_string($email);
    
    $sql = "SELECT * FROM users WHERE email = '$email' ";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['email'] = $user['email'];

            if ($user['admin_rights'] == 1) {
                header('Location: index_admin.php');
            } else {
                header('Location: index_user.php');
            }
            exit();
        } else {
            $invalid_credentials = "Invalid email or password.";
        }
    } else {
        $invalid_credentials = "Invalid email or password.";
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
    <title>Login</title>
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
        .custom-container {
            background-color: #5b97ad;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .left {
            background: linear-gradient(to bottom, #073142, #e7e7c9);
            color: white;
            text-align: center;
        }
        .left img {
            max-width: 300px;
            height: auto;
            margin-bottom: -30px;
        }
        .left p {
            color: #1E5162;
            font-weight: bold;
        }
        .right {
            background-color: #5b97ad;
            color: white;
        }
        .right h1 {
            color: #ffffff;
        }
        .register-link a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }

        .button{
            background-color: #1E5162;
            color: #fff;
            font-weight: 500;
            height: 40px;
            text-decoration: none!important;
            border: #1E5162;
            box-shadow: none;
            border-radius: 5px;
        }
        .button:hover{
            color: #fff;
            background-color: #13333d;
            font-weight: 500;
        }
    </style>
</head>
<body>

    <div class="card mb-3 custom-container" style="max-width: 800px;">
        <div class="row g-0">
            <div class="col-md-5 left d-flex flex-column justify-content-center align-items-center p-4">
                <a href="homepage.html"><img src="img/logo.png" class="img-fluid rounded-start" alt="Whale Logo"></a>
                <p>Dive deep into Video Wonders</p>
            </div>
            <div class="col-md-7 right d-flex flex-column justify-content-center p-4">
                <div class="card-body">
                    <h1 class="card-title">Welcome Back</h1>
                    <form action="login.php" method="post">
                        <!-- Email -->
                        <div class="mb-3 mt-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button type="submit" class="btn button w-100" value="Login">Log in</button>
                        </div>
                        <!-- invalid credentials -->
                        <?php if (isset($invalid_credentials)): ?>
                            <div class="alert alert-danger text-center" role="alert">
                                <?php echo $invalid_credentials; ?>
                            </div>
                        <?php endif; ?>
                    </form>
                    <!-- Register Link -->
                    <div class="register-link text-center mt-4">
                        <p>Don't have an account yet? <a href="register.php">Register here.</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gybM3rUaDiBfVAnQ8O6BdO9IBb6FxT74IVnYFyc+Zq8qE4FQ6U" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-mQ93A+4dMw0i7RY9smMYeToB1y0tUjF1Zaq7OQq9v9Pzsvhb7cYgkWV+0f1W5LuX" crossorigin="anonymous"></script>
</body>
</html>

