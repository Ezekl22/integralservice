<?php

require_once 'includes/DBConnection.php';

class UserDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createUser(User $user) {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO users (nombre, apellido, mail, contrasena, tipo) VALUES (:nombre, :apellido, :mail, :contrasena, :tipo)");
        
        $nombre = $user->getNombre();
        $apellido = $user->getApellido();
        $mail = $user->getMail();
        $contrasena = $user->getContrasena();
        $tipo = $user->getTipo();
        
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
		$stmt->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
		$stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());

		}
        $stmt->closeCursor();
        $stmt = null;
    }

    public function updateUser(User $user) {
        $nombre = $user->getNombre();
        $apellido = $user->getApellido();
        $mail = $user->getMail();
        $contrasena = $user->getContrasena();
        $tipo = $user->getTipo();
        $idusuario = $user->getIdUsuario();

        $txtPassword = $contrasena != ''?' contrasena=:contrasena,':'';
        $query = "UPDATE usuarios SET nombre=:nombre, apellido=:apellido, mail=:mail,".$txtPassword." tipo=:tipo WHERE idusuario=:idusuario";
        $stmt = $this->db->getConnection()->prepare($query);
        
		$stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
		$stmt->bindParam(":apellido", $apellido, PDO::PARAM_STR);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        if($contrasena != ''){
            $stmt->bindParam(":contrasena", $contrasena, PDO::PARAM_STR);
        }
		$stmt->bindParam(":tipo", $tipo, PDO::PARAM_STR);
		$stmt->bindParam(":idusuario",$idusuario , PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r($stmt->errorInfo());

		}

        $stmt->closeCursor();
        $stmt = null;
    }

    public function deleteUser($id) {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM usuarios WHERE idusuario = :idusuario");
        $stmt->bindParam(":idusuario", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            // La eliminación fue exitosa
            return "ok";
        } else {
            // Manejar errores si es necesario
            print_r($this->db->getConnection()->errorInfo());
            return "error";
        }
    }

    public function getUserById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM usuarios WHERE idusuario = ".$id);
        $stmt->execute();
        $retorno = $stmt -> fetchAll()[0];
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }

    public function getAllUsers() {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        $retorno = $stmt -> fetchAll();
        $stmt->closeCursor();
        $stmt = null;
        return $retorno;
    }
}
