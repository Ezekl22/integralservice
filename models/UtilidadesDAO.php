<?php

class UtilidadesDAO
{
    private $db;
    private static $instance = null;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new UtilidadesDAO();
        }
        return self::$instance;
    }

    public function checkExecute(PDOStatement $stmt)
    {
        $error = "";
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();
        }

        $stmt->closeCursor();
        $stmt = null;
        return $error;
    }

    public function executeQuery($query, $params = [])
    {
        $stmt = $this->db->getConnection()->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt;
    }
}

?>