<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
        p{
            color: #1E5162;
            font-weight: bold;
            margin: 0;
        }
        .container {
            background-color: #5b97ad;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 800px;
            display: flex;
            flex-direction: row;
            overflow: hidden;
        }
        .left {
            background: linear-gradient(to bottom, #073142, #e7e7c9);
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 50%;
            color: white;
            text-align: center;
        }
        .left img {
            max-width: 300px;
            height: auto;
            margin-bottom: -30px;
        }
        .right {
            background-color: #5b97ad;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 50%;
        }
        .right h1 {
            color: #ffffff;
            font-size: 36px;
            margin-bottom: 20px;
        }
        .form-group {
            width: 100%;
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            margin-left: 20px;
            color: #ffffff;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 20px;
            box-sizing: border-box;
            background-color: #ffffff;
            font-size: 16px;
        }
        .form-group .submit-btn {
            width: 150px;
            padding: 10px;
            display: block;
            margin-right: 10px;
            background-color: #1e81b0;
            border: none;
            color: #ffffff;
            border-radius: 20px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .form-group .submit-btn:hover {
            background-color: #166d90;
        }
        .register-link {
            margin-top: 10px;
            text-align: center;
        }
        .register-link a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="left">
            <img src="../img/logo.png" alt="Whale Logo">
            <p>Dive deep into Video Wonders</p>
        </div>
        <div class="right">
            <h1>Welcome Back</h1>
            <form action="login_handler.php" method="post">
                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <!-- Password -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <!-- Submit Button -->
                <div class="form-group">
                    <input type="submit" class="submit-btn" value="Login">
                </div>
            </form>
            <!-- Register Link -->
            <div class="register-link">
                <p>Don't have an account yet? <a href="register.php">Register here.</a></p>
            </div>
        </div>
    </div>

</body>
</html>
