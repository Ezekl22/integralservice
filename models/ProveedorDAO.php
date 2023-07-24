<?php

require_once 'includes/DBConnection.php';

class ProveedorDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createProveedor(ProveedorMdl $proveedor) {
        // Código para crear un nuevo proveedor en la base de datos
        // ...
    }

    public function updateProveedor(ProveedorMdl $proveedor) {
        // Código para actualizar un proveedor existente en la base de datos
        $stmt = $this->db->getConnection()->prepare("UPDATE proveedores SET nombre=:nombre, categoria_fiscal=:categoria_fiscal, direccion=:direccion, telefono=:telefono, correo=:correo, saldo=:saldo, fechaCreacion=:fechaCreacion WHERE idproveedor= :idproveedor");
        
        $nombre = $proveedor->getNombre();
        $categoria_fiscal = $proveedor->getCategoriaFiscal();
        $direccion = $proveedor->getDireccion();
        $telefono = $proveedor->getTelefono();
        $correo = $proveedor->getCorreo();
        $saldo = $proveedor->getSaldo();
        $idproveedor = $proveedor->getId();
        
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$stmt->bindParam(":categoria_fiscal", $categoria_fiscal, PDO::PARAM_STR);
        $stmt->bindParam(":direccion", $direccion, PDO::PARAM_STR);
		$stmt->bindParam(":telefono", $telefono, PDO::PARAM_INT);
		$stmt->bindParam(":correo", $correo, PDO::PARAM_STR);
		$stmt->bindParam(":saldo", $saldo, PDO::PARAM_STR);
		$stmt->bindParam(":idproveedor",$idproveedor , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}
        $stmt->close();
        $stmt = null;
    }

    // public function deleteProveedor($id) {
    //     // Código para eliminar un proveedor de la base de datos
    //     // ...
    // }

    public function getProveedorById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM proveedores WHERE idproveedor = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->close();
        $stmt = null;
    }

    public function getAllProveedores() {
        // Código para obtener todos los proveedors desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM proveedores");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;
    }
}
