<?php

require_once 'includes/DBConnection.php';

class GestionPantallasDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function updateUser(GestionPantallas $gestionPantallas) {
        // Código para actualizar si una pantalla se esta usando o no, por el momento solo se usa para la parte de editar
        $stmt = $this->db->getConnection()->prepare("UPDATE gestionpantallas SET name=:inuse WHERE id= :id");
        
        $inUse = $inUse->getInUse();
        $id = $user->getId();
        
		$stmt->bindParam(":inuse", $inUse, PDO::PARAM_BOOL);
		$stmt->bindParam(":id",$id , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());

		}
        $stmt->close();
        $stmt = null;
    }

    public function getGestionPantallasById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM gestionpantallas WHERE id = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->close();
        $stmt = null;
    }

    public function getAllGestionPantallas() {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM gestionpantallas");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;
    }
}
