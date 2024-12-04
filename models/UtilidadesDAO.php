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

    public function checkExecute(PDOStatement $stmt, string $typeQuery, $params = null)
    {
        try {
            $stmt->execute($params);
            $resultado = [];
            if ($stmt->errorCode() !== '00000') { // 00000 indica "sin error"
                throw new Exception("Error en la consulta: " . implode(", ", $stmt->errorInfo()));
            }
            if ($typeQuery == "SELECT") {
                $resultado = $stmt->fetchAll();
            }
            return $typeQuery == "SELECT" ? $resultado : "";
        } catch (Exception $e) {
            return $e->getMessage();
        } finally {
            $stmt->closeCursor();
            $stmt = null;
        }
    }

    public function executeQuery($queries)
    {
        $query = "";
        foreach ($queries as $queryData) {
            $subQuery = $queryData['query'];
            $paramsList = $queryData['params'];
            $typeQuery = $queryData['type'];
            if (count($paramsList) > 0) {
                for ($i = 0; $i < count($paramsList); $i++) {
                    $separador = $i < count($paramsList) - 1 ? "," : "; ";
                    $subQuery = $subQuery . "(" . implode(", ", $paramsList[$i]) . ")" . $separador;
                }
            }
            $query = $query . $subQuery;
        }
        $stmt = $this->db->getConnection()->prepare($query);
        return $this->checkExecute($stmt, $typeQuery);
    }
    public function showStatus(string $module, string $status, string $action = "")
    {
        if ($status == "") {
            header("Location: index.php?module=$module"
                . ($action != "" ? "&action=" . $action : $action) . "&status=success");
        } else {
            header("Location: index.php?module=usuarios"
                . ($action != "" ? "&action=" . $action : $action) . "&status=error&description=" . $status);
        }
    }
}



?>