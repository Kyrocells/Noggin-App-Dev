<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
        .container {
            background-color: #5b97ad;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 600px;
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
            margin-left: 20px;
            margin-bottom: 5px;
            color: #ffffff;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 10px;
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
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="../img/logo.png" alt="Logo">
            </div>
            <h1>Register</h1>
        </div>
        <form action="register_handler.php" method="post">
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <!-- Username -->
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <!-- First Name and Last Name -->
            <div class="form-group inline">
                <div class="first-name-input">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="last-name-input">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
            </div>
            <!-- Phone Number -->
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <!-- Address and City -->
            <div class="form-group inline">
                <div class="address-input">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="city-input">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>
                </div>
            </div>
            <!-- Submit Button -->
            <div class="form-group">
                <input type="submit" class="submit-btn" value="Register">
            </div>
        </form>
        <!-- Login Link -->
        <div class="register-link text-center mt-4">
            <p>Already have an account? <a href="login.php">Login here.</a></p>
        </div>
    </div>

</body>
</html>
