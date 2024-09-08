<?php

require_once '../config/Database.php';
require_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$user_id = $_POST['user_id'] ?? null;
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;
$new_password = $_POST['new_password'] ?? null;

$successMessage = '';
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user_id && $username && $password) {
        if ($user->updateProfile($user_id, $username, $password, $new_password)) {
            $successMessage = 'Profile updated successfully!';
        } else {
            $errorMessage = 'Failed to update profile. Please check your current password.';
        }
    } else {
        $errorMessage = 'Please fill in all required fields.';
    }
}

$current_user = $user->getUserById($user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - Interactive Storytelling Platform</title>
    <style>
        .profile-update {
            max-width: 600px;
            margin: 2rem auto;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .profile-update h2 {
            margin-top: 0;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            padding: 0.75rem 1.5rem;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        /* Messages */
        .message {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="navbar">
            <h1 class="logo">StoryExplorer</h1>
            <nav>
            <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="stories.php">Explore</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="author.php">Author Dashboard</a></li>
                    <li><a href="create.php">Create</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="profile-update">
        <h2>Update Profile</h2>

        <?php if ($successMessage): ?>
        <div class="message success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>
        <?php if ($errorMessage): ?>
        <div class="message error"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <form method="POST" action="profile.php">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username"
                    value="<?php echo htmlspecialchars($current_user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Current Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password">
            </div>
            <button type="submit">Update Profile</button>
        </form>
    </section>
</body>

</html>