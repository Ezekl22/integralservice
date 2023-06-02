<?php

require_once 'includes/DBConnection.php';

class UserDAO {
    private $db;

    public function __construct() {
        $this->db = DBConnection::getInstance();
    }

    public function createUser(User $user) {
        // Código para crear un nuevo usuario en la base de datos
        // ...
    }

    public function updateUser(User $user) {
        // Código para actualizar un usuario existente en la base de datos
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET name=:name, lastname=:lastname, username=:username, password=:password, tipo = :tipo WHERE id= :id");

		$stmt->bindParam(":name", $datos["name"], PDO::PARAM_STR);
		$stmt->bindParam(":lastname", $datos["lastname"], PDO::PARAM_STR);
        $stmt->bindParam(":username", $datos["username"], PDO::PARAM_STR);
		$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt->bindParam(":type", $datos["type"], PDO::PARAM_INT);
		$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			print_r(Conexion::conectar()->errorInfo());

		}
        $stmt->close();
        $stmt = null;
    }

    public function deleteUser($id) {
        // Código para eliminar un usuario de la base de datos
        // ...
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
