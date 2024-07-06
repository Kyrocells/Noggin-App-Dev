<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #a1d8e7;
            font-family: 'Roboto', sans-serif;
        }
        .login-container {
            display: flex;
            background-color: #88b6cb;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .login-container .left-section {
            background: linear-gradient(to bottom, #073142, #e7e7c9);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .login-container .left-section img {
            width: 150px;
        }
        .login-container .left-section p {
            color: #073142; /* Change the font color */
            margin-top: 20px;
            font-size: 18px;
            text-align: center;
        }
        .login-container .right-section {
            background-color: #88b6cb;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
        }
        .login-container .right-section h2 {
            font-size: 24px;
            color: white;
            margin-bottom: 20px;
        }
        .login-container .right-section form {
            display: flex;
            flex-direction: column;
        }
        .login-container .right-section form label {
            color: white;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .login-container .right-section form input {
            margin-bottom: 15px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-family: 'Roboto', sans-serif;
        }
        .login-container .right-section form input[type="submit"] {
            background-color: #ffffff;
            color: #333;
            cursor: pointer;
            font-weight: bold;
        }
        .login-container .right-section form input[type="submit"]:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="left-section">
            <img src="logo.png" alt="Logo">
            <p>Dive deep into Video Wonders</p>
        </div>
        <div class="right-section">
            <h2>Welcome Back</h2>
            <form action="login.php" method="post">
                <label for="email">Email</label>
                <input type="email" name="email" required>
                <label for="password">Password</label>
                <input type="password" name="password" required>
                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
