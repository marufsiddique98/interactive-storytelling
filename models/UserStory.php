<?php

class UserStory {
    private $conn;
    private $table = 'user_stories';

    public $id;
    public $user_id;
    public $story_id;
    public $last_read_chapter_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function trackProgress() {
        $query = "INSERT INTO " . $this->table . " (user_id, story_id, last_read_chapter_id) VALUES (:user_id, :story_id, :last_read_chapter_id) 
                  ON DUPLICATE KEY UPDATE last_read_chapter_id = :last_read_chapter_id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':story_id', $this->story_id);
        $stmt->bindParam(':last_read_chapter_id', $this->last_read_chapter_id);

        return $stmt->execute();
    }

    public function getProgress($user_id, $story_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id AND story_id = :story_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
