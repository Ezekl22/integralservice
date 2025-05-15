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

    public function updatEstado(string $estado, int $idPresupuesto)
    {
        $queries = [
            [
                'query' => "UPDATE presupuestos SET 
                            estado = '" . $estado . "' 
                            WHERE idpresupuesto= " . $idPresupuesto,
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }


    public function updatePresupuesto(PresupuestoMdl $presupuesto)
    {
        $queries = [
            [
                'query' => "UPDATE presupuestos SET
                            total=" . $presupuesto->getTotal() . ", 
                            estado= 'presupuestado' 
                            WHERE idpresupuesto= " . $presupuesto->getIdPresupuesto(),
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function updateManoDeObra($id, $manoDeObra)
    {
        $queries = [
            [
                'query' => "UPDATE reparaciones SET
                            manodeobra=" . $manoDeObra . "
                            WHERE idpresupuesto= " . $id,
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $queries = [
                [
                    'query' => "SELECT presupuestos.idpresupuesto, 
                          presupuestos.idcliente, presupuestos.nrocomprobante, 
                          presupuestos.tipo, presupuestos.estado,
                          presupuestos.fecha,
                          presupuestos.puntoventa,
                          presupuestos.total
                          FROM presupuestos 
                          INNER JOIN clientes ON presupuestos.idcliente = clientes.idcliente
                          WHERE presupuestos.tipo = 'reparacion' 
                          AND presupuestos.nrocomprobante LIKE '$termino'
                          OR presupuestos.tipo LIKE '$termino'
                          OR presupuestos.estado LIKE '$termino'
                          OR presupuestos.fecha LIKE '$termino'
                          OR presupuestos.puntoventa LIKE '$termino'
                          OR CAST(presupuestos.total AS CHAR) LIKE '$termino'
                          OR CONCAT(clientes.nombre, ' ', clientes.apellido) LIKE '$termino'",
                    'type' => 'SELECT',
                    'params' => [],
                ]
            ];
            return UtilidadesDAO::getInstance()->executeQuery($queries);
        }
    }

}
