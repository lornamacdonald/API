<?php
class Database{

    // Database credentials
    private $host = "localhost";
    private $db_name = "api";
    private $username = "root";
    private $password = "Password";
    public $conn;

    // Connect to the database
    public function getConnection() {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username,
                $this->password);
            $this->conn->exec("set names utf8");
        }

        catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>







