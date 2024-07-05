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
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 600px;
            display: flex;
            flex-direction: column; /* Added to stack elements vertically */
        }
        h1 {
            text-align: left; /* Align title to the left */
            color: #ffffff;
            margin-bottom: 20px;
            margin-left: 10px; /* Adjust left margin for positioning */
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #ffffff;
        }
        .form-group input {
            width: calc(100% - 22px); /* Adjusted width calculation */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group.inline {
            display: flex;
            justify-content: space-between;
        }
        .form-group.inline input {
            width: calc(50% - 11px); /* Adjusted width of inputs */
        }
        /* Adjusting width of address input */
        #address {
            width: calc(100% - 22px); /* 100% width minus padding and borders */
        }
        .form-group .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #1e81b0;
            border: none;
            color: #ffffff;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Register</h1>
        <form action="register_handler.php" method="post">
            <!-- Name and Phone Number -->
            <div class="form-group inline">
                <div>
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div>
                    <label for="phone">Phone number</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
            </div>
            <!-- Address and City -->
            <div class="form-group inline">
                <div>
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div>
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>
                </div>
            </div>
            <!-- Email and Password -->
            <div class="form-group inline">
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
            </div>
            <!-- Submit Button -->
            <div class="form-group">
                <input type="submit" class="submit-btn" value="Register">
            </div>
        </form>
    </div>

</body>
</html>
