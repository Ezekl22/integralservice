<?php

class DBConnection {
    private static $instance;
    private $connection;

    private function __construct() {
        $host = 'localhost';
        $dbname = 'integralservice';
        $username = 'root';

        try {
            $this->connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DBConnection();
        }

        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
