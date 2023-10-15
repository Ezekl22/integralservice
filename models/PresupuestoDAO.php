<?php

require_once 'includes/DBConnection.php';

class PresupuestoDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createPresupuesto(PresupuestoMdl $presupuesto) {
    }

    public function updatePresupuesto(PresupuestoMdl $presupuesto) {
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
		$stmt->bindParam(":nrocomprobante", $nroComprobante, PDO::PARAM_INT);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
		$stmt->bindParam(":puntoventa", $puntoVenta, PDO::PARAM_STR);
        $stmt->bindParam(":total", $total, PDO::PARAM_STR_CHAR);
		$stmt->bindParam(":idpresupuesto",$idPresupuesto , PDO::PARAM_INT);

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

    public function getPresupuestoById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE idPresupuesto = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
    }

    public function getAllPresupuestos() {
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
