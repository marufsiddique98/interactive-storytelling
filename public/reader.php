<?php
include '../config/Database.php';
include '../models/Story.php';
include '../models/Chapter.php';
include '../models/Choice.php';

// Initialize database and models
$database = new Database();
$db = $database->getConnection();

$story = new Story($db);
$chapter = new Chapter($db);
$choice = new Choice($db);

// Get the story and current chapter ID from the GET request
$story_id = isset($_GET['story_id']) ? $_GET['story_id'] : 1;  // Default to story_id 1 if not set
$chapter_id = isset($_GET['chapter_id']) ? $_GET['chapter_id'] : $chapter->getFirstChapter($story_id);

// Fetch story details
$story_details = $story->getStoryById($story_id);

// Fetch the current chapter details
$chapter_details = $chapter->getChapterById($chapter_id);

// Fetch choices for the current chapter
$choices = $choice->getChoicesByChapterId($chapter_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $story_details['title']; ?> - Interactive Storytelling Platform</title>
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

    <section class="story-reader">
        <div class="story-content">
            <h2><?php echo $story_details['title']; ?></h2>
            <p>
                <?php echo nl2br($chapter_details['content']);  ?>
                <?php echo $chapter_details['content'];  ?>
            </p>
            <div class="choices">
                <?php foreach ($choices as $choice) { ?>
                    <form action="reader.php" method="GET">
                        <input type="hidden" name="story_id" value="<?php echo $story_id; ?>">
                        <input type="hidden" name="chapter_id" value="<?php echo $choice['next_chapter_id']; ?>">
                        <button type="submit" class="choice-button"><?php echo $choice['text']; ?></button>
                    </form>
                <?php } ?>
            </div>
        </div>

        <div class="story-navigation">
            <!-- Fetch the previous and next chapter based on the story's progress -->
            <?php $previous_chapter = $chapter->getPreviousChapter($chapter_id); ?>
            <?php $next_chapter = $chapter->getNextChapter($chapter_id); ?>

            <form action="reader.php" method="GET" class="inline-form">
                <input type="hidden" name="story_id" value="<?php echo $story_id; ?>">
                <input type="hidden" name="chapter_id" value="<?php echo $previous_chapter; ?>">
                <button type="submit" class="nav-button" <?php if (!$previous_chapter) echo 'disabled'; ?>>Previous</button>
            </form>

            <form action="reader.php" method="GET" class="inline-form">
                <input type="hidden" name="story_id" value="<?php echo $story_id; ?>">
                <input type="hidden" name="chapter_id" value="<?php echo $next_chapter; ?>">
                <button type="submit" class="nav-button" <?php if (!$next_chapter) echo 'disabled'; ?>>Next</button>
            </form>
        </div>
    </section>
</body>
</html>
