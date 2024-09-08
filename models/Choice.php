<?php

class Choice {
    private $conn;
    private $table = 'choices';

    public $id;
    public $chapter_id;
    public $text;
    public $next_chapter_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " (chapter_id, text, next_chapter_id) VALUES (:chapter_id, :text, :next_chapter_id)";
        $stmt = $this->conn->prepare($query);

        $this->text = htmlspecialchars(strip_tags($this->text));

        $stmt->bindParam(':chapter_id', $this->chapter_id);
        $stmt->bindParam(':text', $this->text);
        $stmt->bindParam(':next_chapter_id', $this->next_chapter_id);

        return $stmt->execute();
    }

    public function readByChapter($chapter_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE chapter_id = :chapter_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chapter_id', $chapter_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getChoicesByChapterId($chapter_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE chapter_id = :chapter_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':chapter_id', $chapter_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
