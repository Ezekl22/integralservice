<?php
require_once 'load_env.php';
class DBConnection
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        loadEnv();
        define('DB_HOST', $_ENV['DB_HOST']);
        define('DB_PORT', $_ENV['DB_PORT']);
        define('DB_NAME', $_ENV['DB_NAME']);
        define('DB_USER', $_ENV['DB_USER']);
        define('DB_PASSWORD', $_ENV['DB_PASS']);
        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=utf8", DB_USER, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos:  ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new DBConnection();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function closeConection()
    {
        $this->connection = null;
    }
}
