<?php

class Chapter {
    private $conn;
    private $table = 'chapters';

    public $id;
    public $story_id;
    public $title;
    public $content;
    public $position;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (story_id, title, content, position) VALUES (:story_id, :title, :content, :position)";
        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->content = htmlspecialchars(strip_tags($this->content));

        $stmt->bindParam(':story_id', $this->story_id);
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':content', $this->content);
        $stmt->bindParam(':position', $this->position);

        return $stmt->execute();
    }

    public function readByStory($story_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE story_id = :story_id ORDER BY position";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getFirstChapter($story_id) {
        $query = "SELECT id FROM " . $this->table . " WHERE story_id = :story_id ORDER BY id ASC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['id'] : null;
    }

    // Get chapter by ID
    public function getChapterById($chapter_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :chapter_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chapter_id', $chapter_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get the previous chapter ID
    public function getPreviousChapter($chapter_id) {
        $query = "SELECT id FROM " . $this->table . " WHERE id < :chapter_id ORDER BY id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chapter_id', $chapter_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['id'] : null;
    }

    // Get the next chapter ID
    public function getNextChapter($chapter_id) {
        $query = "SELECT id FROM " . $this->table . " WHERE id > :chapter_id ORDER BY id ASC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chapter_id', $chapter_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['id'] : null;
    }
}
