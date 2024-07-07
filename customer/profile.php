<?php
require_once 'functions.php';


$user_id = $_SESSION['user_id'];
$user = getUserProfile($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $contact_number = $_POST['contact_number'];
    
    // Handle file upload
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "../img/";
        $profile_picture = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $profile_picture);
    } else {
        $profile_picture = $_POST['existing_image'];
    }

    // Update user profile
    if (updateUserProfile($user_id, $username, $password, $first_name, $last_name, $email, $contact_number, $profile_picture)) {
        header('Location: index.php');
        exit();
    } else {
        echo "Failed to update profile.";
    }
}
?>

<div class="container profile_container">
    <div class="edit_profile">
        <h2 class="edit_profile_title">Edit Profile</h2>
        <form action="profile.php" method="post" enctype="multipart/form-data">
            <!-- first and last name -->
            <div class="input-group mt-4">
                <input type="text" class="form-control" name="first_name" placeholder="First Name" aria-label="First Name" value="<?php echo htmlspecialchars($user['first_name']); ?>" readonly >
                <input type="text" class="form-control" name="last_name" placeholder="Last Name" aria-label="Last Name" value="<?php echo htmlspecialchars($user['last_name']); ?>" readonly  >
            </div>
            <!-- username -->
            <div class="form-group mt-4">
                <label for="exampleInputUsername1">Username</label>
                <input type="text" class="form-control" id="exampleInputUsername1" name="username" placeholder="Enter username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <!-- contact number -->
            <div class="form-group mt-4">
                <label for="exampleInputContactNumber1">Contact Number</label>
                <input type="text" class="form-control" id="exampleInputContactNumber1" name="contact_number" placeholder="Enter Contact Number" value="<?php echo htmlspecialchars($user['contact_number']); ?>" required>
            </div>
            <!-- email -->
            <div class="form-group mt-4">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <!-- password -->
            <div class="form-group mt-4">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" required>
            </div>
            <!-- upload image -->
            <div class="form-group">
                <label for="editImage">Profile Picture</label>
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" style="max-width: 200px; display: block; margin-bottom: 10px;">
                <?php endif; ?>
                <input type="file" class="form-control" id="editImage" name="image">
                <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($user['profile_picture']); ?>">
            </div>
            <!-- hidden user_id -->
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <!-- confirm button -->
            <button type="submit" class="confirm_button mt-4">Confirm</button>
        </form>
    </div>
</div>
