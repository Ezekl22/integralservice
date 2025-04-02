<?php

require_once 'includes/DBConnection.php';

class ReparacionDAO
{
    private $db;
    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function repair(ReparacionMdl $reparacion)
    {
        $id = $reparacion->getId();
        //aca hay que validar que el estado de la reparacion sea "pendiente de reparacion". De lo contrario no se podrá reparar.
        $stmt = $this->db->getConnection()->prepare("UPDATE reparaciones SET estado = 'reparado' WHERE idReparacion = " . $id);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }

    public function evaluate(ReparacionMdl $reparacion)
    {
        $id = $reparacion->getId();
        //aca hay que validar que el estado de la reparacion sea "pendiente de evaluacion". De lo contrario no se podrá evaluar.
        $stmt = $this->db->getConnection()->prepare("UPDATE reparaciones SET estado = 'evaluado' WHERE idReparacion = " . $id);
        //aca hay que hacer la logica de que el reparador pueda dejar un comentario de la evaluacion y reflejarlo en la base de datos
        //la pantalla de evaluar es como la de editar de los otros modulos, pero solo se puede modificar el campo "descripcion"
    }


    public function updateReparacion(ReparacionMdl $presupuesto)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE reparaciones SET idcliente=:idcliente,
        nrocomprobante=:nrocomprobante, estado=:estado, fecha=:fecha, puntoventa=:puntoventa,
         total=:total WHERE idpresupuesto= :idpresupuesto");

        // $idCliente = $presupuesto->getIdCliente();
        // $nroComprobante = $presupuesto->getNrocomprobante();
        // $estado = $presupuesto->getEstado();
        // $fecha = $presupuesto->getFecha();
        // $puntoVenta = $presupuesto->getPuntoVenta();
        // $total = $presupuesto->getTotal();
        // $idReparacion = $presupuesto->getIdReparacion();

        $stmt->bindParam(":idcliente", $idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":nrocomprobante", $nroComprobante, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":puntoventa", $puntoVenta, PDO::PARAM_STR);
        $stmt->bindParam(":total", $total, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":idpresupuesto", $idReparacion, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }

    public function getReparacionById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM reparaciones WHERE idReparacion = " . $id);

        $stmt->execute();
        $resultado = $stmt->fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;

    }

    public function getAllReparaciones()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM reparaciones WHERE estado != 'reparado' AND estado != 'facturado' AND estado != 'anulado'");

        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;

    }

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $query = "SELECT reparaciones.idpresupuesto, 
                      reparaciones.idcliente, reparaciones.nrocomprobante, 
                      reparaciones.tipo, reparaciones.estado,
                      reparaciones.fecha,
                      reparaciones.puntoventa,
                      reparaciones.total
                      FROM reparaciones 
                      INNER JOIN clientes ON reparaciones.idcliente = clientes.idcliente
                      WHERE reparaciones.estado != 'cancelado'
                      AND reparaciones.nrocomprobante LIKE '$termino'
                      OR reparaciones.tipo LIKE '$termino'
                      OR reparaciones.estado LIKE '$termino'
                      OR reparaciones.fecha LIKE '$termino'
                      OR reparaciones.puntoventa LIKE '$termino'
                      OR CAST(reparaciones.total AS CHAR) LIKE '$termino'
                      OR CONCAT(clientes.nombre, ' ', clientes.apellido) LIKE '$termino'";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            $retorno = $stmt->fetchAll();
            $stmt->closeCursor();
            $stmt = null;
            return $retorno;
        }
    }

    public function getProductosReparacionById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT productos.idproducto, productos.nombre, productos.marca, productos.detalle, 
                                                     productosreparaciones.cantidad, productos.precioventa, 
                                                     productosreparaciones.cantidad * productos.precioventa AS total
                                                     FROM productosreparaciones
                                                     INNER JOIN productos ON productosreparaciones.idproducto = productos.idproducto
                                                     WHERE productosreparaciones.idpresupuesto = " . $id);

        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
    }

    public function annul($id)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE reparaciones SET estado = 'anulado' WHERE idReparacion = " . $id);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }
}
