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
                'query' => "SELECT presupuestos.idpresupuesto, presupuestos.idcliente, presupuestos.nrocomprobante, presupuestos.tipo, estadopresupuesto.nombre as estado, presupuestos.fecha, presupuestos.puntoventa, presupuestos.total FROM presupuestos
                            INNER JOIN estadopresupuesto ON presupuestos.idestadopresupuesto = estadopresupuesto.idestadopresupuesto
                            WHERE estadopresupuesto.nombre != 'anulado'
                            AND presupuestos.tipo = 'Reparacion'",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    public function updatEstado(string $estado, int $idPresupuesto)
    {
        $idEstadoPresupuesto = $this->getIdEstadoPresupuesto($estado);
        $queries = [
            [
                'query' => "UPDATE presupuestos SET 
                            idestadopresupuesto = " . $idEstadoPresupuesto . "
                            WHERE idpresupuesto = " . $idPresupuesto,
                'type' => 'UPDATE',
                'params' => [],
            ]
        ];
        return UtilidadesDAO::getInstance()->executeQuery($queries);
    }

    private function getIdEstadoPresupuesto($estado)
    {
        $queries = [
            [
                'query' => "SELECT idestadopresupuesto FROM estadopresupuesto WHERE nombre = '" . $estado . "'",
                'type' => 'SELECT',
                'params' => [],
            ]
        ];
        $result = UtilidadesDAO::getInstance()->executeQuery($queries);
        return count($result) > 0 ? $result[0]['idestadopresupuesto'] : null;
    }

    public function updatePresupuesto(PresupuestoMdl $presupuesto)
    {
        $idEstadoPresupuesto = $this->getIdEstadoPresupuesto('presupuestado');
        $queries = [
            [
                'query' => "UPDATE presupuestos SET
                            total=" . $presupuesto->getTotal() . ", 
                            idestadopresupuesto = " . $idEstadoPresupuesto . " 
                            WHERE idpresupuesto = " . $presupuesto->getIdPresupuesto(),
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
                          presupuestos.tipo, estadopresupuesto.nombre,
                          presupuestos.fecha,
                          presupuestos.puntoventa,
                          presupuestos.total
                          FROM presupuestos 
                          INNER JOIN clientes ON presupuestos.idcliente = clientes.idcliente
                          INNER JOIN estadopresupuesto ON presupuestos.idestadopresupuesto = estadopresupuesto.idestadopresupuesto
                          WHERE presupuestos.tipo = 'Reparacion' 
                          AND (presupuestos.nrocomprobante LIKE '$termino'
                          OR presupuestos.tipo LIKE '$termino'
                          OR estadopresupuesto.nombre LIKE '$termino'
                          OR presupuestos.fecha LIKE '$termino'
                          OR presupuestos.puntoventa LIKE '$termino'
                          OR CAST(presupuestos.total AS CHAR) LIKE '$termino'
                          OR CONCAT(clientes.nombre, ' ', clientes.apellido) LIKE '$termino')",
                    'type' => 'SELECT',
                    'params' => [],
                ]
            ];
            return UtilidadesDAO::getInstance()->executeQuery($queries);
        }
    }

}
