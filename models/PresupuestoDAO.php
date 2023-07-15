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
        $stmt = $this->db->getConnection()->prepare("UPDATE presupuestos SET idclient=:idclient, 
        nrocomprobante=:nrocomprobante, estado=:estado, fecha=:fecha, puntoventa=:puntoventa,
         total=:total WHERE idpresupuesto= :idpresupuesto");
        
        $idClient = $presupuesto->getIdClient();
        $nroComprobante = $presupuesto->getNrocomprobante();
        $estado = $presupuesto->getEstado();
        $fecha = $presupuesto->getFecha();
        $puntoVenta = $presupuesto->getPuntoVenta();
        $total = $presupuesto->getTotal();
        $idPresupuesto = $presupuesto->getIdPresupuesto();
        
		$stmt->bindParam(":idclient", $idClient, PDO::PARAM_INT);
		$stmt->bindParam(":nrocomprobante", $nroComprobante, PDO::PARAM_INT);
        $stmt->bindParam(":estado", $estado, PDO::PARAM_STR);
		$stmt->bindParam(":fecha", $fecha, PDO::PARAM_STR);
		$stmt->bindParam(":puntoventa", $puntoVenta, PDO::PARAM_STR);
        $stmt->bindParam(":total", $total, PDO::PARAM_FLOAT);
		$stmt->bindParam(":idpresupuesto",$idPresupuesto , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());

		}
        $stmt->close();
        $stmt = null;
    }

    public function deletePresupuesto($idPresupuesto) {
        // Código para eliminar un usuario de la base de datos
        // ...
    }

    public function getUserById($idPresupuesto) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE idPresupuesto = ".$idPresupuesto);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->close();
        $stmt = null;
    }

    public function getAllPresupuestos() {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;
    }
}
