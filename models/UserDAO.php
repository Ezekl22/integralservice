<?php

require_once 'includes/DBConnection.php';

class UserDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createUser(User $user) {
        $stmt = $this->db->getConnection()->prepare("INSERT INTO users (name, lastname, mail, password, type) VALUES (:name, :lastname, :mail, :password, :type)");
        
        $name = $user->getName();
        $lastname = $user->getLastname();
        $mail = $user->getMail();
        $password = $user->getPassword();
        $type = $user->getType();
        
		$stmt->bindParam(":name", $name, PDO::PARAM_STR);
		$stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
		$stmt->bindParam(":password", $password, PDO::PARAM_STR);
		$stmt->bindParam(":type", $type, PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());

		}
        $stmt->close();
        $stmt = null;
    }

    public function updateUser(User $user) {
        $name = $user->getName();
        $lastname = $user->getLastname();
        $mail = $user->getMail();
        $password = $user->getPassword();
        $type = $user->getType();
        $id = $user->getId();

        $txtPassword = $password != ''?' password=:password,':'';
        $query = "UPDATE users SET name=:name, lastname=:lastname, mail=:mail,".$txtPassword." type=:type WHERE id=:id";
        $stmt = $this->db->getConnection()->prepare($query);
        
		$stmt->bindParam(":name", $name, PDO::PARAM_STR);
		$stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":mail", $mail, PDO::PARAM_STR);
        if($password != ''){
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
        }
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

    public function deleteUser($id) {
        $stmt = $this->db->getConnection()->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    
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
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE id = ".$id);

        $stmt->execute();
        return $stmt -> fetchAll()[0];
        $stmt->close();
        $stmt = null;
    }

    public function getAllUsers() {
        // Código para obtener todos los usuarios desde la base de datos
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users");

        $stmt->execute();
        return $stmt -> fetchAll();
        $stmt->close();
        $stmt = null;
    }
}
