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
        $stmt = $this->db->getConnection()->prepare("UPDATE presupuestos SET name=:name, lastname=:lastname, username=:username, password=:password, type = :type WHERE id= :id");
        
        $name = $user->getName();
        $lastname = $user->getLastname();
        $username = $user->getUsername();
        $password = $user->getPassword();
        $type = $user->getType();
        $id = $user->getId();
        
		$stmt->bindParam(":name", $name, PDO::PARAM_STR);
		$stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
		$stmt->bindParam(":password", $password, PDO::PARAM_STR);
		$stmt->bindParam(":type", $type, PDO::PARAM_STR);
		$stmt->bindParam(":id",$id , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());

		}
        $stmt->close();
        $stmt = null;
    }

    public function deletePresupuesto($id) {
        // Código para eliminar un usuario de la base de datos
        // ...
    }

    public function getUserById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM presupuestos WHERE idPresupuesto = ".$id);

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
