<?php
class Database {
    private $host     = 'localhost';
    private $username = 'root';
    private $password = '';
    private $db       = 'simple_library_db';

    protected $conn;

    public function connect() {
        try {
            
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4",
                $this->username,
                $this->password
            );

        
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->conn;
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
}
