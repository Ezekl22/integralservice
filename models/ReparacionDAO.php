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

    // public function search()
    // {
    //     $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
    //     if ($termino != "") {
    //         $query = "SELECT reparaciones.idpresupuesto, 
    //                   reparaciones.idcliente, reparaciones.nrocomprobante, 
    //                   reparaciones.tipo, reparaciones.estado,
    //                   reparaciones.fecha,
    //                   reparaciones.puntoventa,
    //                   reparaciones.total
    //                   FROM reparaciones 
    //                   INNER JOIN clientes ON reparaciones.idcliente = clientes.idcliente
    //                   WHERE reparaciones.estado != 'cancelado'
    //                   AND reparaciones.nrocomprobante LIKE '$termino'
    //                   OR reparaciones.tipo LIKE '$termino'
    //                   OR reparaciones.estado LIKE '$termino'
    //                   OR reparaciones.fecha LIKE '$termino'
    //                   OR reparaciones.puntoventa LIKE '$termino'
    //                   OR CAST(reparaciones.total AS CHAR) LIKE '$termino'
    //                   OR CONCAT(clientes.nombre, ' ', clientes.apellido) LIKE '$termino'";
    //         $stmt = $this->db->getConnection()->prepare($query);
    //         $stmt->execute();
    //         $retorno = $stmt->fetchAll();
    //         $stmt->closeCursor();
    //         $stmt = null;
    //         return $retorno;
    //     }
    // }

}
