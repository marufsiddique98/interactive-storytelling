<?php
require_once '../config/Database.php';
require_once '../models/Story.php';

$database = new Database();
$db = $database->getConnection();
$story = new Story($db);

$stories = $story->getAllStories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Stories - Interactive Storytelling Platform</title>
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

    <section class="all-stories">
        <h2>Explore Stories</h2>
        <?php if (!empty($stories)) { ?>
            <div class="story-grid">
                <?php foreach ($stories as $story_item) { ?>
                    <div class="story-card">
                        <h3><?php echo htmlspecialchars($story_item['title']); ?></h3>
                        <p><?php echo htmlspecialchars($story_item['description']); ?></p>
                        <p><strong>Genre:</strong> <?php echo htmlspecialchars($story_item['genre']); ?></p>
                        <p><strong>Tags:</strong> <?php echo htmlspecialchars($story_item['tags']); ?></p>
                        <p><strong>Published:</strong> <?php echo htmlspecialchars($story_item['created_at']); ?></p>
                        <p><strong>Rating:</strong> ★<?php echo htmlspecialchars($story_item['rating']); ?>/5</p>
                        <a href="reader.php?story_id=<?php echo $story_item['id']; ?>" class="read-story-button">Read Story</a>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>No stories available. Please check back later.</p>
        <?php } ?>
    </section>
</body>
</html>
