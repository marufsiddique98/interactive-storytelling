<?php

class Story
{
    private $conn;
    private $table_name = "stories";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create a new story
    public function createStory($title, $description, $genre, $tags, $created_at, $rating, $author_id)
    {
        $query = "INSERT INTO " . $this->table_name . " (title, description, genre, tags, created_at, rating, author_id) 
                  VALUES (:title, :description, :genre, :tags, :created_at, :rating, :author_id)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':tags', $tags);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':author_id', $author_id);

        return $stmt->execute();
    }

    public function countStoriesByAuthor($author_id) {
        $query = "SELECT COUNT(*) as count FROM stories WHERE author_id = :author_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }

    public function getStoriesByAuthor($author_id) {
        $query = "SELECT id, title, rating, reads FROM stories WHERE author_id = :author_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->execute();
        
        $stories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stories[] = $row;
        }
        return $stories;
    }

    // Get all stories
    public function getAllStories()
    {
        $query = "SELECT id, title, description, genre, tags, created_at, rating, author_id FROM " . $this->table_name;
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a single story by ID
    public function getStoryById($story_id)
    {
        $query = "SELECT id, title, description, genre, tags, created_at, rating, author_id FROM " . $this->table_name . " WHERE id = :story_id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':story_id', $story_id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a story by ID
    public function updateStory($id, $title, $description, $genre, $tags, $created_at, $rating)
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET title = :title, description = :description, genre = :genre, tags = :tags, created_at = :created_at, rating = :rating 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':genre', $genre);
        $stmt->bindParam(':tags', $tags);
        $stmt->bindParam(':created_at', $created_at);
        $stmt->bindParam(':rating', $rating);

        return $stmt->execute();
    }

    // Delete a story by ID
    public function deleteStory($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}

?>
