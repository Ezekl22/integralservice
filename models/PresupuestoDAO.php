<?php

require_once 'includes/DBConnection.php';

class PresupuestoDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function create(PresupuestoMdl $presupuesto, ReparacionMdl $reparacion = new ReparacionMdl("", "", "", "", "", 0))
    {

        $productos = $presupuesto->getProductos();
        $productosValues = "";



        for ($i = 0; $i < count($productos); $i++) {
            $idProducto = $productos[$i]->getIdProducto();
            $preciounit = $productos[$i]->getPreciounit();
            $cantidad = $productos[$i]->getCantidad();
            $separacion = $i != count($productos) - 1 ? ', ' : ';';
            $productosValues = $productosValues . ' (@idpresupuesto, ' . $idProducto . ', ' . $preciounit . ', ' . $cantidad . ')' . $separacion;
        }
        if ($presupuesto->getTipo() == "Venta") {
            $query = 'INSERT INTO productospresupuestos (idpresupuesto, idproducto, preciounit, cantidad) VALUES ' . $productosValues;
        } elseif ($presupuesto->getTipo() == "Reparacion") {
            $query = 'INSERT INTO reparaciones (idpresupuesto, modelo, marca, numeroserie, descripcion) VALUES ' .
                '(@idpresupuesto, "' . $reparacion->getModelo() . '", "' . $reparacion->getMarca() . '", "' . $reparacion->getNumeroSerie() . '", "' . $reparacion->getDescripcion() . '");';
        }
        $stmt = $this->db->getConnection()->prepare('INSERT INTO presupuestos (idcliente, nrocomprobante, tipo, estado, fecha, puntoventa, total)' .
            'VALUES (:idcliente, :nrocomprobante, :tipo, :estado, :fecha, :puntoventa, :total); ' .
            'SET @idpresupuesto = LAST_INSERT_ID(); ' . $query);
        $idCliente = $presupuesto->getIdCliente();
        $nroComprobante = $presupuesto->getNroComprobante();
        $tipo = $presupuesto->getTipo();
        $estado = $presupuesto->getEstado();
        $fecha = date("d-m-Y");
        $puntoVenta = $presupuesto->getPuntoVenta();
        $total = $presupuesto->getTotal();
        $stmt->bindParam(":idcliente", $idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":nrocomprobante", $nroComprobante, PDO::PARAM_STR);
        $stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":puntoventa", $puntoVenta, PDO::PARAM_STR);
        $stmt->bindParam(":total", $total, PDO::PARAM_STR_CHAR);

        if ($stmt->execute()) {

            return "ok";

        } else {
            $error = $stmt->errorInfo();
        }

        $stmt->closeCursor();
        $stmt = null;

        return $error;
    }

    public function updatePresupuesto(PresupuestoMdl $presupuesto)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE presupuestos SET idcliente=:idcliente,
        nrocomprobante=:nrocomprobante, estado=:estado, fecha=:fecha, puntoventa=:puntoventa,
         total=:total WHERE idpresupuesto= :idpresupuesto");

        $idCliente = $presupuesto->getIdCliente();
        $nroComprobante = $presupuesto->getNrocomprobante();
        $estado = $presupuesto->getEstado();
        $fecha = $presupuesto->getFecha();
        $puntoVenta = $presupuesto->getPuntoVenta();
        $total = $presupuesto->getTotal();
        $idPresupuesto = $presupuesto->getIdPresupuesto();

        $stmt->bindParam(":idcliente", $idCliente, PDO::PARAM_INT);
        $stmt->bindParam(":nrocomprobante", $nroComprobante, PDO::PARAM_STR);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":puntoventa", $puntoVenta, PDO::PARAM_STR);
        $stmt->bindParam(":total", $total, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":idpresupuesto", $idPresupuesto, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }

    public function getNuevoNroComprobante()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT MAX(idpresupuesto) FROM presupuestos");

        $stmt->execute();
        $resultado = $stmt->fetchAll()[0][0];
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;

    }

    public function getPresupuestoById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE idPresupuesto = " . $id);

        $stmt->execute();
        $resultado = $stmt->fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;

    }

    public function getAllPresupuestos()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE estado != 'anulado'");

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
            $query = "SELECT presupuestos.idpresupuesto, 
                      presupuestos.idcliente, presupuestos.nrocomprobante, 
                      presupuestos.tipo, presupuestos.estado,
                      presupuestos.fecha,
                      presupuestos.puntoventa,
                      presupuestos.total
                      FROM presupuestos 
                      INNER JOIN clientes ON presupuestos.idcliente = clientes.idcliente
                      WHERE presupuestos.estado != 'cancelado'
                      AND presupuestos.nrocomprobante LIKE '$termino'
                      OR presupuestos.tipo LIKE '$termino'
                      OR presupuestos.estado LIKE '$termino'
                      OR presupuestos.fecha LIKE '$termino'
                      OR presupuestos.puntoventa LIKE '$termino'
                      OR CAST(presupuestos.total AS CHAR) LIKE '$termino'
                      OR CONCAT(clientes.nombre, ' ', clientes.apellido) LIKE '$termino'";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            $retorno = $stmt->fetchAll();
            $stmt->closeCursor();
            $stmt = null;
            return $retorno;
        }
    }

    public function getProductosPresupuestoById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT productos.idproducto, productos.nombre, productos.marca, productos.detalle, 
                                                     productospresupuestos.cantidad, productos.precioventa, 
                                                     productospresupuestos.cantidad * productos.precioventa AS total
                                                     FROM productospresupuestos
                                                     INNER JOIN productos ON productospresupuestos.idproducto = productos.idproducto
                                                     WHERE productospresupuestos.idpresupuesto = " . $id);

        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
    }

    public function getReparacionPresupuestoById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT modelo, marca, numeroserie, descripcion
                                                     FROM reparaciones
                                                     WHERE reparaciones.idpresupuesto = " . $id);

        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
    }

    public function annul($id)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE presupuestos SET estado = 'anulado' WHERE idPresupuesto = " . $id);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }
}
