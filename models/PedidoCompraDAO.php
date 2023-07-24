<?php

require_once 'includes/DBConnection.php';

class PedidoCompraDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createPedidoCompra(PedidoCompraMdl $pedidocompra) {
    }

    public function updatePedidoCompra(PedidoCompraMdl $pedidocompra) {
        $stmt = $this->db->getConnection()->prepare("UPDATE pedidoscompras SET idproveedor=:idproveedor, 
        nrocomprobante=:nrocomprobante, estado=:estado, fecha=:fecha,
         total=:total WHERE idpedidocompra= :idpedidocompra");
        
        $idPedidoCompra = $pedidocompra->getIdPedidoCompra();
        $idProveedor = $pedidocompra->getIdProveedor();
        $nroComprobante = $pedidocompra->getNrocomprobante();
        $estado = $pedidocompra->getEstado();
        $fecha = $pedidocompra->getFecha();
        $total = $pedidocompra->getTotal();
        
		$stmt->bindParam(":idProveedor", $idProveedor, PDO::PARAM_INT);
		$stmt->bindParam(":nrocomprobante", $nroComprobante, PDO::PARAM_INT);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
        $stmt->bindParam(":total", $total, PDO::PARAM_STR_CHAR);
		$stmt->bindParam(":idPedidoCompra",$idPedidoCompra , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}
        $stmt->closeCursor();
        $stmt = null;
    }

    // public function deletePresupuesto($idPresupuesto) {
    //     // Código para eliminar un usuario de la base de datos
    //     // ...
    // }

    public function getPedidoCompraById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE idPresupuesto = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
    }

    public function getAllPedidosCompras() {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->closeCursor();
        $stmt = null;
    }

    public function getProductosPresupuestoById($id){

        $stmt = $this->db->getConnection()->prepare("SELECT productos.nombre,productos.marca, productos.detalle,productospresupuestos.cantidad, productos.precioventa , productospresupuestos.cantidad * productos.precioventa AS total
                                                     FROM productospresupuestos
                                                     INNER JOIN productos ON productospresupuestos.idproducto = productos.idproducto
                                                     WHERE productospresupuestos.idpresupuesto = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->closeCursor();
        $stmt = null;
    }

}
