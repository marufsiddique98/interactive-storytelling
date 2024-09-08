<?php

class Feedback {
    private $conn;
    private $table = 'feedback';

    public $id;
    public $user_id;
    public $story_id;
    public $content;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (user_id, story_id, content) VALUES (:user_id, :story_id, :content)";
        $stmt = $this->conn->prepare($query);

        $this->content = htmlspecialchars(strip_tags($this->content));

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':story_id', $this->story_id);
        $stmt->bindParam(':content', $this->content);

        return $stmt->execute();
    }

    public function getByStory($story_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE story_id = :story_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
