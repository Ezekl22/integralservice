<?php

require_once 'includes/DBConnection.php';

class SupplierDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createSupplier(Supplier $supplier) {
        // Código para crear un nuevo proveedor en la base de datos
        // ...
    }

    public function updateSupplier(Supplier $supplier) {
        // Código para actualizar un proveedor existente en la base de datos
        $stmt = $this->db->getConnection()->prepare("UPDATE suppliers SET name=:name, tax_category=:tax_category, adress=:adress, phone=:phone, mail=:mail, balance=:balance WHERE id= :id");
        
        $name = $supplier->getName();
        $lastname = $supplier->getTaxCategory();
        $adress = $supplier->getAdress();
        $phone = $supplier->getPhone();
        $mail = $supplier->getMail();
        $balance = $supplier->getBalance();
        $id = $supplier->getId();
        
		$stmt->bindParam(":name", $name, PDO::PARAM_STR);
		$stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":adress", $adress, PDO::PARAM_STR);
		$stmt->bindParam(":phone", $phone, PDO::PARAM_INT);
		$stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
		$stmt->bindParam(":balance", $balance, PDO::PARAM_STR);
		$stmt->bindParam(":id",$id , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());

		}
        $stmt->close();
        $stmt = null;
    }

    public function deleteSupplier($id) {
        // Código para eliminar un proveedor de la base de datos
        // ...
    }

    public function getSupplierById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM suppliers WHERE id = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->close();
        $stmt = null;
    }

    public function getAllSuppliers() {
        // Código para obtener todos los proveedors desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM suppliers");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;
    }
}
