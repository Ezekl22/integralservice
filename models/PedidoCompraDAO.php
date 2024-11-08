<?php

require_once 'includes/DBConnection.php';

class PedidoCompraDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
    }

    public function create(PedidoCompraMdl $pedidocompra)
    {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO pedidoscompras (nrocomprobante, idproveedor, estado, total, fecha) VALUES (:nrocomprobante, :idproveedor, :estado, :total, :fecha)");

        $idPedidoCompra = $pedidocompra->getIdPedidoCompra();
        $nroComprobante = $pedidocompra->getNrocomprobante();
        $idProveedor = $pedidocompra->getIdProveedor();
        $estado = $pedidocompra->getEstado();
        $total = $pedidocompra->getTotal();
        $fecha = $pedidocompra->getFecha();

        $stmt->bindParam(":nrocomprobante", $nroComprobante, PDO::PARAM_INT);
        $stmt->bindParam(":idProveedor", $idProveedor, PDO::PARAM_INT);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":total", $total, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":idPedidoCompra", $idPedidoCompra, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";

        } else {
            $error = $stmt->errorInfo();

        }

        $stmt->closeCursor();
        $stmt = null;

        return $error;
    }

    public function update(PedidoCompraMdl $pedidocompra)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE pedidoscompras SET nrocomprobante=:nrocomprobante, idproveedor=:idproveedor, 
         estado=:estado,
         total=:total, fecha=:fecha WHERE idpedidocompra= :idpedidocompra");

        $idPedidoCompra = $pedidocompra->getIdPedidoCompra();
        $nroComprobante = $pedidocompra->getNrocomprobante();
        $idProveedor = $pedidocompra->getIdProveedor();
        $estado = $pedidocompra->getEstado();
        $total = $pedidocompra->getTotal();
        $fecha = $pedidocompra->getFecha();

        $stmt->bindParam(":nrocomprobante", $nroComprobante, PDO::PARAM_INT);
        $stmt->bindParam(":idProveedor", $idProveedor, PDO::PARAM_INT);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
        $stmt->bindParam(":total", $total, PDO::PARAM_STR_CHAR);
        $stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":idPedidoCompra", $idPedidoCompra, PDO::PARAM_INT);

        if ($stmt->execute()) {

            return "ok";

        }
        $stmt->closeCursor();
        $stmt = null;
    }


    public function getPedidoCompraById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM pedidoscompras WHERE idpedidocompra = " . $id);

        $stmt->execute();
        return $stmt->fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
    }

    public function getAllPedidosCompras()
    {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM pedidoscompras");

        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
    }

    public function getProductosPedidoCompraById($id)
    {

        $stmt = $this->db->getConnection()->prepare("SELECT productos.nombre,productos.marca, productos.detalle,productospresupuestos.cantidad, productos.precioventa , productospresupuestos.cantidad * productos.precioventa AS total
                                                     FROM productospresupuestos
                                                     INNER JOIN productos ON productospresupuestos.idproducto = productos.idproducto
                                                     WHERE productospresupuestos.idpedidocompra = " . $id);

        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
    }

    public function annul($id)
    {
        $stmt = $this->db->getConnection()->prepare("UPDATE pedidoscompras SET estado = 'anulado' WHERE idpedidocompra = " . $id);

        if ($stmt->execute()) {

            return "ok";

        } else {

            print_r($stmt->errorInfo());

        }
        $stmt->closeCursor();
        $stmt = null;
    }

    public function search()
    {
        $termino = isset($_POST['termino']) ? '%' . $_POST['termino'] . '%' : "";
        if ($termino != "") {
            $query = "SELECT pedidoscompras.idpedidocompra, 
                      pedidoscompras.idproveedor, pedidoscompras.nrocomprobante,
                      pedidoscompras.estado,
                      pedidoscompras.fecha,
                      pedidoscompras.total
                      FROM pedidoscompras 
                      INNER JOIN proveedores ON pedidoscompras.idproveedor = proveedores.idproveedor
                      WHERE pedidoscompras.estado != 'anulado'
                      AND pedidoscompras.nrocomprobante LIKE '$termino'
                      OR pedidoscompras.estado LIKE '$termino'
                      OR pedidoscompras.fecha LIKE '$termino'
                      OR proveedores.nombre LIKE '$termino'";
            $stmt = $this->db->getConnection()->prepare($query);
            $stmt->execute();
            $retorno = $stmt->fetchAll();
            $stmt->closeCursor();
            $stmt = null;
            return $retorno;
        }
    }

    public function getProductosPedidoById($id)
    {
        $stmt = $this->db->getConnection()->prepare("SELECT productos.idproducto, productos.nombre, productos.marca, productos.detalle, 
                                                     productospedidoscompras.cantidad, productos.precioventa, 
                                                     productospedidoscompras.cantidad * productos.precioventa AS total
                                                     FROM productospedidoscompras
                                                     INNER JOIN productos ON productospedidoscompras.idproducto = productos.idproducto
                                                     WHERE productospedidoscompras.idpedidocompra = " . $id);

        $stmt->execute();
        $resultado = $stmt->fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
    }


}
