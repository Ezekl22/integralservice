<?php

require_once 'includes/DBConnection.php';

class PresupuestoDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function create(PresupuestoMdl $presupuesto) {
        $productos = $presupuesto->getProductos();
        $productosValues = "";
        for($i = 0; $i < count($productos); $i++) {
            $idProducto = $productos[$i]->getIdProducto();
            $preciounit = $productos[$i]->getPreciounit();
            $cantidad = $productos[$i]->getCantidad();
            $separacion = $i != count($productos)-1?', ': ';';
            $productosValues = $productosValues.' (@idpresupuesto, '.$idProducto.', '.$preciounit.', '.$cantidad.')'.$separacion;
        }
        $stmt = $this->db->getConnection()->prepare('INSERT INTO presupuestos (idcliente, nrocomprobante, tipo, estado, fecha, puntoventa, total)'. 
                                                     'VALUES (:idcliente, :nrocomprobante, :tipo, :estado, :fecha, :puntoventa, :total);'.
                                                     'SET @idpresupuesto = LAST_INSERT_ID();'.
                                                     'INSERT INTO productospresupuestos (idpresupuesto, idproducto, preciounit, cantidad) VALUES '.$productosValues);

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

		if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());

		}

        $stmt->closeCursor();
        $stmt = null;
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

		}else{

			print_r($stmt->errorInfo());

		}
        $stmt->closeCursor();
        $stmt = null;
    }

    public function getNuevoNroComprobante(){
        $stmt = $this->db->getConnection()->prepare("SELECT MAX(idpresupuesto) FROM presupuestos");

        $stmt->execute();
        $resultado = $stmt -> fetchAll()[0][0];
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
        
    }
    
    public function getPresupuestoById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE idPresupuesto = ".$id);

        $stmt->execute();
        $resultado = $stmt -> fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $resultado; 
        
    }

    public function getAllPresupuestos() {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE estado != 'cancelado'");

        $stmt->execute();
        $resultado = $stmt -> fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
        
    }

    public function getProductosPresupuestoById($id){
        $stmt = $this->db->getConnection()->prepare("SELECT productos.idproducto, productos.nombre, productos.marca, productos.detalle, 
                                                     productospresupuestos.cantidad, productos.precioventa, 
                                                     productospresupuestos.cantidad * productos.precioventa AS total
                                                     FROM productospresupuestos
                                                     INNER JOIN productos ON productospresupuestos.idproducto = productos.idproducto
                                                     WHERE productospresupuestos.idpresupuesto = ".$id);

        $stmt->execute();
        $resultado = $stmt -> fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $resultado;
    }

    public function cancel($id){
        $stmt = $this->db->getConnection()->prepare("UPDATE presupuestos SET estado = 'cancelado' WHERE idPresupuesto = ".$id);

        if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());

		}
        $stmt->closeCursor();
        $stmt = null;
    }

    public function facturar($id){
        $stmt = $this->db->getConnection()->prepare("UPDATE presupuestos SET estado = 'Facturado' WHERE idPresupuesto = ".$id." AND estado NOT IN  ('Cancelado','Pendiente presupuesto','En reparacion')");

        if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());

		}
        $stmt->closeCursor();
        $stmt = null;
    }

}
