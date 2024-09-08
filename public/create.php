<?php
require_once '../config/Database.php';
require_once '../models/Story.php';

$database = new Database();
$db = $database->getConnection();
$story = new Story($db);

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$title = $description = $genre = $tags = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $genre = $_POST['genre'];
    $tags = $_POST['tags'];
    $author_id = $_SESSION['user_id'];
    $published_date = date('Y-m-d'); 
    $rating = 0.0; 

    if (empty($title) || empty($description)) {
        $error_message = "Title and Description are required!";
    } else {
        $result = $story->createStory($title, $description, $genre, $tags, $published_date, $rating, $author_id);
        if ($result) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error_message = "Error creating story. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Story - Interactive Storytelling Platform</title>
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

    <section class="story-creator">
        <div class="creator-header">
            <h2>Create Your Story</h2>
            <?php if (!empty($error_message)) { ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php } ?>
        </div>

        <form action="createstory.php" method="POST">
            <div class="story-details">
                <label for="story-title">Story Title:</label>
                <input type="text" id="story-title" name="title" placeholder="Enter your story title..." value="<?php echo htmlspecialchars($title); ?>">

                <label for="story-description">Story Description:</label>
                <textarea id="story-description" name="description" placeholder="Write your story content here..."><?php echo htmlspecialchars($description); ?></textarea>

                <label for="story-genre">Genre:</label>
                <input type="text" id="story-genre" name="genre" placeholder="Enter genre (optional)" value="<?php echo htmlspecialchars($genre); ?>">

                <label for="story-tags">Tags (comma-separated):</label>
                <input type="text" id="story-tags" name="tags" placeholder="Enter tags (optional)" value="<?php echo htmlspecialchars($tags); ?>">
            </div>

            <div class="story-actions">
                <button type="submit" class="save-button">Save Story</button>
            </div>
        </form>
    </section>
</body>
</html>
