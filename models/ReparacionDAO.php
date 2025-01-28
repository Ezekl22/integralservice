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
        $queries = [
            [
                'query' => "SELECT * FROM presupuestos
                            WHERE estado != 'anulado'
                            AND tipo = 'reparacion'",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function reparar($id)
    {
        $queries = [
            [
                'query' => "UPDATE presupuestos SET 
                            estado = 'Reparado'
                            WHERE idpresupuesto= " . $id,
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }
}