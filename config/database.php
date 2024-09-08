<?php

class Database {
    private $conn;

    public function getConnection() {
        $this->conn = null;

        // Load environment variables from the .env file
        $this->loadEnv(__DIR__ . '/../.env');

        $host = getenv('DB_HOST');
        $db_name = getenv('DB_NAME');
        $username = getenv('DB_USER');
        $password = getenv('DB_PASS');
        $port = getenv('DB_PORT');

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db_name;port=$port", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }

    // Load the environment variables from the .env file
    private function loadEnv($file) {
        if (!file_exists($file)) {
            throw new Exception('The .env file does not exist.');
        }

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv("$name=$value");
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}
