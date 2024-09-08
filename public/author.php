<?php

require_once '../config/Database.php';
require_once '../models/User.php';
require_once '../models/Story.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$story = new Story($db);

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

$current_user = $user->getUserById($user_id);
if (!$current_user) {
    echo "User not found.";
    exit;
}

$total_stories = $story->countStoriesByAuthor($user_id);
$stories = $story->getStoriesByAuthor($user_id);

$total_reads = 0;
$total_rating = 0;
$new_comments = 12;

foreach ($stories as $s) {
    $total_reads += $s['reads']; 
    $total_rating += $s['rating'];
}
$average_rating = $total_stories > 0 ? ($total_rating / $total_stories) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author Dashboard - Interactive Storytelling Platform</title>
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

    <section class="dashboard">
        <div class="dashboard-header">
            <h2>Welcome, <?php echo htmlspecialchars($current_user['username']); ?></h2>
            <p>Manage your stories and track their performance.</p>
        </div>

        <div class="dashboard-overview">
            <div class="overview-card">
                <h3>Total Stories</h3>
                <p><?php echo htmlspecialchars($total_stories); ?></p>
            </div>
            <div class="overview-card">
                <h3>Total Reads</h3>
                <p><?php echo htmlspecialchars(number_format($total_reads)); ?></p>
            </div>
            <div class="overview-card">
                <h3>Average Rating</h3>
                <p><?php echo htmlspecialchars(number_format($average_rating, 1)); ?> ★</p>
            </div>
            <div class="overview-card">
                <h3>New Comments</h3>
                <p><?php echo htmlspecialchars($new_comments); ?></p>
            </div>
        </div>

        <div class="dashboard-actions">
            <button class="new-story-button" onclick="window.location.href='create.php'">Create New Story</button>
        </div>

        <div class="story-list">
            <h3>Your Stories</h3>
            <?php foreach ($stories as $s): ?>
            <div class="story-card">
                <h4><?php echo htmlspecialchars($s['title']); ?></h4>
                <p><strong>Reads:</strong> <?php echo htmlspecialchars(number_format($s['reads'])); ?> | <strong>Rating:</strong> <?php echo htmlspecialchars(number_format($s['rating'], 1)); ?> ★</p>
                <div class="story-card-actions">
                    <button class="edit-button" onclick="window.location.href='edit_story.php?id=<?php echo $s['id']; ?>'">Edit</button>
                    <button class="analytics-button" onclick="window.location.href='analytics.php?id=<?php echo $s['id']; ?>'">View Analytics</button>
                    <form action="delete_story.php" method="POST" style="display:inline;">
                        <input type="hidden" name="story_id" value="<?php echo $s['id']; ?>">
                        <button type="submit" class="delete-button">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>
