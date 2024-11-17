<?php

require_once 'includes/DBConnection.php';

class ReparacionDAO
{
    private $db;
    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function getAllReparaciones()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE estado != 'anulado' AND tipo = 'reparacion'");

        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
    }
}