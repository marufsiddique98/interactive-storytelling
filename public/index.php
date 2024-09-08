<?php
require_once '../config/Database.php';
require_once '../models/Story.php';

$database = new Database();
$db = $database->getConnection();
$story = new Story($db);

$featured_stories = $story->getAllStories(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Interactive Storytelling Platform</title>
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
                    <li><a href="create.php">Create</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="author.php">Author Dashboard</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero-section">
        <div class="hero-content">
            <h2>Discover, Read, and Create Interactive Stories</h2>
            <p>Welcome to StoryExplorer, where your choices shape the journey. Explore countless stories or create your own!</p>
            <a href="allstories.php" class="explore-button">Explore Stories</a>
        </div>
    </section>

    <section class="featured-stories">
        <h2>Featured Stories</h2>
        <?php if (!empty($featured_stories)) { ?>
            <div class="story-list">
                <?php foreach ($featured_stories as $story_item) { ?>
                    <div class="story-card">
                        <h3><?php echo htmlspecialchars($story_item['title']); ?></h3>
                        <p><?php echo htmlspecialchars($story_item['description']); ?></p>
                        <p><strong>Genre:</strong> <?php echo htmlspecialchars($story_item['genre']); ?></p>
                        <p><strong>Tags:</strong> <?php echo htmlspecialchars($story_item['tags']); ?></p>
                        <a href="singlestory.php?story_id=<?php echo $story_item['id']; ?>" class="read-story-button">Read Story</a>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>No featured stories available. Please check back later.</p>
        <?php } ?>
    </section>

    <footer>
        <p>&copy; 2024 StoryExplorer - All Rights Reserved</p>
    </footer>
</body>
</html>
