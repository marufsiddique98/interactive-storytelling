<?php

require_once '../config/Database.php';
require_once '../models/Story.php';
require_once '../models/User.php'; 

$database = new Database();
$db = $database->getConnection();
$story = new Story($db);
$user = new User($db);

$story_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$story_details = $story->getStoryById($story_id);

if (!$story_details) {
    echo "Story not found.";
    exit;
}

$author_name = "Unknown";
$author_query = "SELECT username FROM users WHERE id = :author_id";
$author_stmt = $db->prepare($author_query);
$author_stmt->bindParam(':author_id', $story_details['author_id'], PDO::PARAM_INT);
$author_stmt->execute();
$author_result = $author_stmt->fetch(PDO::FETCH_ASSOC);
if ($author_result) {
    $author_name = $author_result['username'];
}

$isBookmarked = false;
if (isset($user_id)) {
    $bookmark_query = "SELECT COUNT(*) FROM bookmarks WHERE user_id = :user_id AND story_id = :story_id";
    $bookmark_stmt = $db->prepare($bookmark_query);
    $bookmark_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $bookmark_stmt->bindParam(':story_id', $story_id, PDO::PARAM_INT);
    $bookmark_stmt->execute();
    $isBookmarked = $bookmark_stmt->fetchColumn() > 0;
}

$story_title = htmlspecialchars($story_details['title']);
$story_url = "http://yourdomain.com/story-details.php?id=" . $story_id; // Adjust URL accordingly

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $story_title; ?> - Interactive Storytelling Platform</title>
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

    <section class="story-details">
        <div class="story-header">
            <h2><?php echo htmlspecialchars($story_details['title']); ?></h2>
            <p>by <a href="#"><?php echo htmlspecialchars($author_name); ?></a></p>
        </div>

        <div class="story-meta">
            <p><strong>Genre:</strong> <?php echo htmlspecialchars($story_details['genre']); ?></p>
            <p><strong>Tags:</strong> <?php echo htmlspecialchars($story_details['tags']); ?></p>
            <p><strong>Published:</strong> <?php echo htmlspecialchars(date('F j, Y', strtotime($story_details['created_at']))); ?></p>
            <p><strong>Rating:</strong>
                <?php echo htmlspecialchars(str_repeat('★', floor($story_details['rating']))) . str_repeat('☆', 5 - floor($story_details['rating'])); ?>
                (<?php echo htmlspecialchars($story_details['rating']); ?>)
            </p>
        </div>

        <div class="story-description">
            <h3>Description</h3>
            <p><?php echo nl2br(htmlspecialchars($story_details['description'])); ?></p>
        </div>

        <div class="story-actions">
            <!-- Start Reading Button -->
            <form action="reader.php" method="GET" class="inline-form">
                <input type="hidden" name="story_id" value="<?php echo $story_id; ?>">
                <button type="submit" class="read-button">Start Reading</button>
            </form>

            <!-- Bookmark Button -->
            <?php if (isset($user_id)) { ?>
            <form action="bookmark.php" method="POST" class="inline-form">
                <input type="hidden" name="story_id" value="<?php echo $story_id; ?>">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button type="submit" class="bookmark-button">
                    <?php echo $isBookmarked ? 'Unbookmark' : 'Bookmark'; ?>
                </button>
            </form>
            <?php } else { ?>
            <a href="login.php" class="bookmark-button">Bookmark</a>
            <?php } ?>

            <!-- Share Button -->
            <button class="share-button" onclick="shareStory('<?php echo $story_title; ?>', '<?php echo $story_url; ?>')">Share</button>
        </div>

        <script>
            function shareStory(title, url) {
                if (navigator.share) {
                    navigator.share({
                        title: title,
                        url: url
                    }).then(() => {
                        console.log('Story shared successfully!');
                    }).catch((error) => {
                        console.log('Error sharing:', error);
                    });
                } else {
                    alert('Sharing not supported on this browser.');
                }
            }
        </script>

    </section>
</body>
</html>
