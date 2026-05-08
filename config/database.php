<?php
// config/database.php

class Database {
    private $host = 'localhost';
    private $db   = 'food_order';
    private $user = 'root';
    private $pass = 'myposadminauthentication';
    private $port = 3306;
    private $charset = 'utf8mb4';

    private $pdo = null;

    public function getConnection() {
     
        if ($this->pdo === null) {

            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset={$this->charset}";

            try {

                $this->pdo = new PDO(
                    $dsn,
                    $this->user,
                    $this->pass,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );

            } catch (PDOException $e) {

                die("Database Connection Failed: " . $e->getMessage());

            }
        }

        return $this->pdo;
    }
}
?>
