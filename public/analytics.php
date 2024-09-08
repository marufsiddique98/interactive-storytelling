<?php
require_once '../config/database.php';  
require_once '../models/Story.php';  
require_once '../models/StoryAnalytics.php';  

$story_id = $_GET['story_id'] ?? 1;  

$database = new Database();
$db = $database->getConnection();
$story = new Story($db);
$analytics = new StoryAnalytics($db);

$story_details = $story->getStoryById($story_id);

$total_reads = $analytics->getTotalReads($story_id);
$average_time_spent = $analytics->getAverageTimeSpent($story_id);
$completion_rate = $analytics->getCompletionRate($story_id);
$popular_choice = $analytics->getPopularChoice($story_id);
$reads_over_time = $analytics->getReadsOverTime($story_id);
$popular_choices = $analytics->getPopularChoices($story_id);
$time_spent_per_section = $analytics->getTimeSpentPerSection($story_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard - Interactive Storytelling Platform</title>
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

    <section class="analytics-dashboard">
        <div class="dashboard-header">
            <h2>Analytics for "<?php echo htmlspecialchars($story_details['title']); ?>"</h2>
            <p>View detailed analytics and insights about your story's performance.</p>
        </div>

        <div class="dashboard-overview">
            <div class="overview-card">
                <h3>Total Reads</h3>
                <p><?php echo number_format($total_reads); ?></p>
            </div>
            <div class="overview-card">
                <h3>Average Time Spent</h3>
                <p><?php echo number_format($average_time_spent, 2); ?> minutes</p>
            </div>
            <div class="overview-card">
                <h3>Completion Rate</h3>
                <p><?php echo number_format($completion_rate, 2); ?>%</p>
            </div>
            <div class="overview-card">
                <h3>Popular Choice</h3>
                <p><?php echo htmlspecialchars($popular_choice); ?></p>
            </div>
        </div>

        <div class="analytics-charts">
            <div class="chart">
                <h4>Reads Over Time</h4>
                <div class="chart-container">
                    <div class="dummy-chart">Chart Placeholder for Reads Over Time</div>
                </div>
            </div>

            <div class="chart">
                <h4>Popular Choices</h4>
                <div class="chart-container">
                    <div class="dummy-chart">Chart Placeholder for Popular Choices</div>
                </div>
            </div>

            <div class="chart">
                <h4>Time Spent Per Section</h4>
                <div class="chart-container">
                    <div class="dummy-chart">Chart Placeholder for Time Spent Per Section</div>
                </div>
            </div>
        </div>

        <div class="back-button-container">
            <button class="back-button" onclick="window.location.href='dashboard.php'">Back to Dashboard</button>
        </div>
    </section>
</body>
</html>
