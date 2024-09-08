<?php

class StoryAnalytics {
    private $conn;
    private $table = 'story_analytics';

    public $id;
    public $story_id;
    public $chapter_id;
    public $time_spent;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function trackTime() {
        $query = "INSERT INTO " . $this->table . " (story_id, chapter_id, time_spent) VALUES (:story_id, :chapter_id, :time_spent)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':story_id', $this->story_id);
        $stmt->bindParam(':chapter_id', $this->chapter_id);
        $stmt->bindParam(':time_spent', $this->time_spent);

        return $stmt->execute();
    }

    public function getAnalyticsByStory($story_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE story_id = :story_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalReads($story_id) {
        $query = "SELECT COUNT(*) as total_reads FROM reads WHERE story_id = :story_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_reads'];
    }

    public function getAverageTimeSpent($story_id) {
        $query = "SELECT AVG(time_spent) as avg_time_spent FROM user_activity WHERE story_id = :story_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['avg_time_spent'];
    }

    public function getCompletionRate($story_id) {
        $query = "SELECT (COUNT(DISTINCT user_id) / (SELECT COUNT(*) FROM user_activity WHERE story_id = :story_id)) * 100 as completion_rate FROM user_activity WHERE story_id = :story_id AND completed = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['completion_rate'];
    }

    public function getPopularChoice($story_id) {
        $query = "SELECT choice_text FROM choices WHERE story_id = :story_id ORDER BY popularity DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['choice_text'] : 'N/A';
    }

    public function getReadsOverTime($story_id) {
        // Placeholder for actual query
        return [];
    }

    public function getPopularChoices($story_id) {
        // Placeholder for actual query
        return [];
    }

    public function getTimeSpentPerSection($story_id) {
        // Placeholder for actual query
        return [];
    }
}
