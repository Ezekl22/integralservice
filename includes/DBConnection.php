<?php

class DBConnection
{
    private static $instance;
    private $connection;

    private function __construct()
    {
        //configuracion de la DB para el servidor de google cloud
        define('DB_HOST', '127.0.0.1');
        define('DB_PORT', '3306');
        define('DB_NAME', 'integralservice');
        define('DB_USER', 'integralservice');
        define('DB_PASSWORD', 'Integralservice');

        // configuracion para ambiente local
        // define('DB_HOST', 'localhost');
        // define('DB_PORT', '');
        // define('DB_NAME', 'integralservice');
        // define('DB_USER', 'root');
        // define('DB_PASSWORD', ''); 

        try {
            $this->connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error de conexión a la base de datos: ' . $e->getMessage());
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
