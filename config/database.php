<?php
// config/database.php
class Database {
    private $host = 'localhost';
    private $db   = 'food_order';
    private $user = 'root';
    private $pass = 'database';
    private $pdo;

    public function getConnection() {
        if ($this->pdo === null) {
            $dsn = "mysql:host=$this->host;dbname=$this->db;charset=utf8mb4";
            try {
                $this->pdo = new PDO($dsn, $this->user, $this->pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }
        }
        return $this->pdo;
    }
}